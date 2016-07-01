/**
 * Created by Boris on 6/30/2016.
 */
window.onsubmit=validateForm;

function validateForm() {
    var psw = document.getElementById("psw").value;
    var psw2 = document.getElementById("psw2").value;
    // validating passwords          
    if (psw == psw2) {
        return true;
    } else {
        alert("Passwords do not match.\nPlease Try again.");
        return false;
    }
}