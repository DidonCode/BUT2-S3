const passwordInput = document.getElementById("newPassword");

const profileInput = document.getElementById("settings-profile-image-upload");
const profilePreview = document.getElementById("settings-profile-image-preview");

const settingAccountBlock = document.getElementsByClassName("setting-account-block");

profileInput.onchange = function() {
    var reader = new FileReader();

    reader.onloadend = function() {
        profilePreview.src = reader.result;
    }

    if (profileInput.files && profileInput.files[0]) {
        reader.readAsDataURL(profileInput.files[0]);
    }
}

for(let i = 0; i < settingAccountBlock.length; i++){
    if(settingAccountBlock[i] != null){
        const deleteBlock = document.getElementsByClassName("settings-account-block")[0];

        if(deleteBlock != null){
            deleteBlock.onclick = function(){
                let formData = new FormData();
                const nameValue = deleteBlock.getAttribute('name');
                formData.append('accountUnblock', nameValue);
                fetch('php/api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if(settingAccountBlock[i].parentNode){
                        settingAccountBlock[i].parentNode.removeChild(settingAccountBlock[i]);
                    }
                });
            }
        }
    }
}


function hasNumber(str) {
    return /\d/.test(str);
}

function hasSpecialChar(str) {
  return /[^A-Za-z0-9]/.test(str);
}

function hasUpperCase(str) {
    return /[A-Z]/.test(str);
}

function checkPasswordStrength(){
    const passwordValue = passwordInput.value;

    const upperCase = document.getElementById("account-password-checker-uppercase");
    const number = document.getElementById("account-password-checker-number");
    const length = document.getElementById("account-password-checker-length");
    const specialCaracter = document.getElementById("account-password-checker-special_character");

    if(hasUpperCase(passwordValue)){
        upperCase.classList.add("setting-password-checker-valid");
    }
    else{
        upperCase.classList.add("setting-password-checker-refuse");
    }

    if(hasNumber(passwordValue)){
        number.classList.add("setting-password-checker-valid");
    }
    else{
        number.classList.add("setting-password-checker-refuse");
    }

    if(passwordValue.length >= 10){
        length.classList.add("setting-password-checker-valid");
    }
    else{
        length.classList.add("setting-password-checker-refuse");
    }

    if(hasSpecialChar(passwordValue)){
        specialCaracter.classList.add("setting-password-checker-valid");
    }
    else{
        specialCaracter.classList.add("setting-password-checker-refuse");
    }
}

if(passwordInput != null){
    passwordInput.onkeyup = function(){
        checkPasswordStrength();
    }
}