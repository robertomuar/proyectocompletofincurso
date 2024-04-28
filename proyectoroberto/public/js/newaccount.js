function isValidAccount() {
   
 
    var codReturn = true;
 
    if (document.newaccount.passworduser.value !== document.newaccount.repeatpassworduser.value) {
        codReturn = false;
    }
    if (document.newaccount.passworduser.value.length < 8) {
        codReturn = false;
    }

    var validationMessage = document.getElementById("validationMessage");
    if (codReturn) {
        validationMessage.textContent = "Contraseña válida";
        validationMessage.style.color = "green";
    } else {
        validationMessage.textContent = "La contraseña no es válida";
        validationMessage.style.color = "red";
    }
 
   
 
    return codReturn; 
}
