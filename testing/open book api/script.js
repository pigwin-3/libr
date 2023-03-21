function isbnToimg() {
    const isbn = document.getElementById("isbn").value;
    const baseUrl = "https://covers.openlibrary.org/b/isbn/";
    const sizes = ["S", "M", "L"];
    const imgUrls = sizes.map(size => `${baseUrl}${isbn}-${size}.jpg`);
    const outputDiv = document.getElementById("output-1");
    outputDiv.innerHTML = imgUrls.map(url => `<img src="${url}" />`).join("");
  }
  