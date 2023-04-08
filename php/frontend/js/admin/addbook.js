const isbnInput = document.getElementById("isbn");
const titleInput = document.getElementById("title");
const authorInput = document.getElementById("author");
const olidInput = document.getElementById("olid");

function getDataFromISBN() {
  const isbn = document.getElementById('isbn').value;
  //console.log('https://openlibrary.org/api/books?bibkeys=ISBN:' + isbn + '&jscmd=data&format=json')

  fetch(`https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&jscmd=data&format=json`)
    .then(response => response.json())
    .then(data => {
        const book = data['ISBN:' + isbn];
        const title = book.title;
        const author = book.authors[0].name;
        const openLibraryId = book.identifiers.openlibrary[0];

        console.log(data);

        olidInput.value = openLibraryId;
        titleInput.value = title;
        authorInput.value = author;

        isbnInput.classList.add("admin-autofill-correct");
        titleInput.classList.add("admin-autofill-correct");
        authorInput.classList.add("admin-autofill-correct");
        olidInput.classList.add("admin-autofill-correct");
        setTimeout(() => {
            isbnInput.classList.remove("admin-autofill-correct");
            titleInput.classList.remove("admin-autofill-correct");
            authorInput.classList.remove("admin-autofill-correct");
            olidInput.classList.remove("admin-autofill-correct");
        }, 2000);
    })
    .catch(error => {
      console.error(error);
      alert(`Error: Book with ISBN: "${isbn}" not found`);
      isbnInput.classList.add("admin-autofill-wrong");
      setTimeout(() => {
        isbnInput.classList.remove("admin-autofill-wrong");
    }, 2000);
    });
}

validateaddbook();

function validateaddbook() {
  fetch("https://openlibrary.org/books/OL24620058M.json")
  .then(response => response.json())
  .then(data => {
    if (data.error === "notfound") {
      console.log("Error 'notfound'.");
    } else {
      console.log("olid all good!");
    }
  })
  .catch(error => console.error(error));
}
