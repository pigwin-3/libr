function isbnToTitle() {
    let isbn = document.getElementById("isbn").value;
    console.log(isbn)
    fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbn)
        .then((response) => response.json())
        .then(           
            data => {
                let items = data.items
                var elem = ""
                items.forEach(element => {
                    console.log(element.volumeInfo)
                    elem += "<h2>" + element.volumeInfo.title + "</h2>"
                    elem += "<img src='" + element.volumeInfo.imageLinks.smallThumbnail + "' alt='book cover'></img>"
                });
                document.getElementById("output-isbnToTitle").innerHTML = elem;
            }
        );
}
function titleToISBN() {
    let title = document.getElementById("title").value;
    console.log("https://www.googleapis.com/books/v1/volumes?q=title:" + title)
    fetch("https://www.googleapis.com/books/v1/volumes?q=title:" + title)
    .then((response) => response.json())
    .then(data => {
        console.log(data)
        let items = data.items
        var elem = ""
        items.forEach(element => {
            console.log(element.volumeInfo)
            elem += "<h2>" + element.volumeInfo.title + "</h2>"
            if (element.volumeInfo.authors && element.volumeInfo.authors.length > 0) {
                elem += "<p>Author: " + element.volumeInfo.authors[0] + "</p>"
            } else {
                elem += "<p>Author not found</p>"
            }
            if (element.volumeInfo.imageLinks && element.volumeInfo.imageLinks.smallThumbnail) {
                elem += "<img src='" + element.volumeInfo.imageLinks.smallThumbnail + "' alt='book cover'></img>"
            } else {
                elem += "<p>No image available</p>"
            }
            var industryIdentifiers = element.volumeInfo.industryIdentifiers;
            var isbn13 = industryIdentifiers ? industryIdentifiers.find(identifier => identifier.type === 'ISBN_13')?.identifier : null;
            if (isbn13) {
                elem += "<p>ISBN-13: " + isbn13 + "</p>"
            } else {
                elem += "<p>ISBN-13 not found</p>"
            }
        });
        document.getElementById("output-titleToISBN").innerHTML = elem;
    });

}