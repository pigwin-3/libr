var scanner, modal;

function docReady(fn) {
  // see if DOM is already available
  if (document.readyState === "complete"
    || document.readyState === "interactive") {
    // call on next available tick
    setTimeout(fn, 1);
  } else {
    document.addEventListener("DOMContentLoaded", fn);
  }
}

function openModal() {
  modal = document.getElementById("modal-container");
  modal.style.display = "block"; // show the modal
  start(); // start the QR code scanner
}

function closeModal() {
  modal.style.display = "none"; // hide the modal
  stop(); // stop the QR code scanner
  informer.style.display = "none"; // hide the modal
}

function inform() {
  informer = document.getElementById("informer");
  informer.style.display = "block"; // show the modal
}

function start() {
  inform()
  document.getElementById("informer-info").innerHTML = "scan book";
  

  docReady(function () {
    var resultContainer = document.getElementById('qr-reader-results');
    var lastResult, countResults = 0;

    function onScanSuccess(decodedText, decodedResult) {
      // what to scan for 0 = scan book 1 = user card
      if (sessionStorage.getItem("scanable") == 1) {
        // doesnt ruin evryting
      }else{
        sessionStorage.setItem("scanable", "0");
        console.log('test004')
      }
      if (decodedText !== lastResult) {
        ++countResults;
        lastResult = decodedText;
        // Handle on success condition with the decoded message.
        console.log(`Scan result ${decodedText}`, decodedResult);
        if (sessionStorage.getItem("scanable") == 0) {
          document.getElementById("informer-info").innerHTML = "scan user card";
          sessionStorage.setItem("scanable", "1");
          document.getElementById("bid").value = decodedText;
        }else{
          console.log('test001')
          sessionStorage.removeItem("scanable");
          closeModal(); // close the modal after scanning
          document.getElementById("uid").value = decodedText;
          scanner.clear();
        }
        console.log('test002')
        document.getElementById('qr-reader-results').innerHTML = `Scan result ${decodedText}`;
      }
    }

    scanner = new Html5QrcodeScanner(
      "qr-reader", { fps: 10, qrbox: 250 });
    scanner.render(onScanSuccess);
  });
}

function stop() {
  scanner.clear();
}
