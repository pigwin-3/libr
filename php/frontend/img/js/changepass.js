function validateChange() {
    console.log((document.getElementById('username').value).length)
    if (document.getElementById('password').value != document.getElementById('password2').value) {
        alert("Passordene du skrev er ikke like!")
        return false;
    }
    //might add more later but this is the only one i can make without any problems
    return true;
}