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
}

function start() {
  docReady(function () {
    var resultContainer = document.getElementById('qr-reader-results');
    var lastResult, countResults = 0;
    function onScanSuccess(decodedText, decodedResult) {
      if (decodedText !== lastResult) {
        ++countResults;
        lastResult = decodedText;
        // Handle on success condition with the decoded message.
        console.log(`Scan result ${decodedText}`, decodedResult);
        scanner.clear();
        console.log("test2");
        document.getElementById('qr-reader-results').innerHTML = `Scan result ${decodedText}`;
        closeModal(); // close the modal after scanning
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
