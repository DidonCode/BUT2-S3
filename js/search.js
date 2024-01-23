let typingTimer;
const searchInput = document.getElementsByClassName("search-input")[0];
const searchResult = document.getElementsByClassName("search-result")[0];

function addResult(profile, pseudo){
    const searchAccount = document.createElement("div");
    searchAccount.classList.add("search-account");

    const accountLink = document.createElement("a");
    accountLink.href = "profile.php?profile=" + pseudo;
    
    const accountProfile = document.createElement("img");
    accountProfile.src = profile;

    const accountPseudo = document.createElement("span");
    accountPseudo.textContent = pseudo;

    accountLink.appendChild(accountProfile);
    accountLink.appendChild(accountPseudo);

    searchAccount.appendChild(accountLink);

    searchResult.appendChild(searchAccount);
}

function search(){
    let formData = new FormData();
    formData.append('search', searchInput.value);
    fetch('php/api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        searchResult.innerHTML = '';
        if(data != ""){
            const parsedData = JSON.parse(data);
            for(let i = 0; i < parsedData.length; i++){
                addResult(parsedData[i]['profile'], parsedData[i]['pseudo']);
            }
        }else{
            const error = document.createElement("p");
            error.classList.add("search-error");
            error.textContent = "Nous avons pas trouvé de compte";
            searchResult.appendChild(error);
        }
    })
}

searchInput.onkeydown = function(){
    clearTimeout(typingTimer);
    typingTimer = setTimeout(search, 500);
}