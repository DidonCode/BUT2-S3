const followButton = document.getElementsByClassName("profile-follow-button")[0];
const followerCount = document.getElementsByClassName('profile-follower-count')[0];

if(followButton != null){
    followButton.addEventListener("click", function (event) {

        const urlParams = new URLSearchParams(window.location.search);
        const accountId = urlParams.get('profile');

        let formData = new FormData();
        if(isFollowed == true || isWaiting == true){ formData.append('follow', 2); }
        else { formData.append('follow', 1); }

        formData.append('account', accountId);

        fetch('php/api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data != ""){
                const parsedData = JSON.parse(data);

                if(parsedData == "unfollow"){
                    followButton.innerText = "Suivre";
                    if(!isWaiting){
                        followerCount.innerText = (parseInt(followerCount.innerText) - 1) + " followers";
                    }
                    isWaiting = false;
                    isFollowed = false;
                }

                if(parsedData == "followed"){
                    followButton.innerText = "Suivi(e)";
                    followerCount.innerText = (parseInt(followerCount.innerText) + 1) + " followers";
                    isFollowed = true;
                }

                if(parsedData == "requested"){
                    followButton.innerText = "Demandé";
                    isWaiting = true;
                }

                if(parsedData == "error"){
                    followButton.innerText = "Error";
                }
            }
        })
    });
}

const moreOption = document.getElementsByClassName("profile-header-option")[0];
if(moreOption != null){
    moreOption.onclick = function(){
        openProfilOptionView(true);
    }
}

const moreOptionBlock = document.getElementsByClassName("profile-popup-option-block")[0];
if(moreOptionBlock != null){
    moreOptionBlock.onclick = function(){
        let formData = new FormData();
        const urlParams = new URLSearchParams(window.location.search);
        const accountId = urlParams.get('profile');

        formData.append('accountBlock', accountId);
        fetch('php/api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data != ""){
                const parsedData = JSON.parse(data);
                document.body.insertAdjacentHTML('beforeend', parsedData);
            }
            openProfilOptionView(false);
        });
    }
}

const moreOptionUnblock = document.getElementsByClassName("profile-popup-option-unblock")[0];
if(moreOptionUnblock != null){
    moreOptionUnblock.onclick = function(){
        let formData = new FormData();
        const urlParams = new URLSearchParams(window.location.search);
        const accountId = urlParams.get('profile');

        formData.append('accountUnblock', accountId);
        fetch('php/api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            
        });
    }
}

const moreOptionReport = document.getElementsByClassName("profile-popup-option-report")[0];
if(moreOptionReport != null){
    moreOptionReport.onclick = function(){
        let formData = new FormData();
        const urlParams = new URLSearchParams(window.location.search);
        const accountId = urlParams.get('profile');

        formData.append('accountReport', accountId);
        fetch('php/api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data != ""){
                const parsedData = JSON.parse(data);
                document.body.insertAdjacentHTML('beforeend', parsedData);
            }
            openProfilOptionView(false);
        })
    }
}

const moreOptionClose = document.getElementsByClassName("profile-popup-option-close")[0];
if(moreOptionClose != null){
    moreOptionClose.onclick = function(){
        openProfilOptionView(false);
    }
}

function openProfilOptionView(open){
    var body = document.getElementsByTagName("body")[0];
    var postPopup = document.getElementsByClassName("profile-popup-option")[0];

    var postPopupBackground = document.getElementsByClassName("profile-popup-option-background")[0];
    if(open){
        postPopup.style.display = "flex";
        postPopupBackground.style.display = "block";
        body.style.overflowY = "hidden";
    }
    else{
        postPopup.style.display = "none";
        postPopupBackground.style.display = "none";
        body.style.overflowY = "visible";
    }
}