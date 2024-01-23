const messageContent = document.getElementsByClassName("message-content")[0];

window.onload = function(){
	if(messageContent != null){
		messageContent.scrollTo(0, messageContent.scrollHeight);
		refreshMessage();
	}
};

function makeView(){
	let viewDiv = document.createElement("div");
	viewDiv.setAttribute('class', 'message-view');

	let view = document.createElement("p");
	view.textContent = "Vu";

	viewDiv.appendChild(view);
	return viewDiv;
}

function removeView(){
	const messageView = document.getElementsByClassName("message-view")[0];
	if(messageView != null){
		messageView.parentNode.removeChild(messageView);
	}
}

function refreshMessage(){
	let formData = new FormData();
    const urlParams = new URLSearchParams(window.location.search);
    const accountPseudo = urlParams.get('direct');

    formData.append('receiverRefresh', accountPseudo);
    fetch('php/api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if(data != ""){
        	const parsedData = JSON.parse(data);

        	if(parsedData[0] != ""){
				messageContent.insertAdjacentHTML('beforeend', parsedData[0]);
				messageContent.scrollTo(0, messageContent.scrollHeight);
				removeView();
			}

			if(parsedData[1] == "view"){
				removeView();
				const messageDiv = messageContent.getElementsByTagName("div");
				const lastMessage = messageDiv[messageDiv.length - 1];

				if(lastMessage.className == "message-receiver"){
					messageContent.appendChild(makeView());	
				}
			}
        }
    });

    const contactName = document.getElementsByClassName("contact-name");
    for(let i = 0; i < contactName.length; i++){
    	if(contactName[i].innerText == accountPseudo){
    		const viewNotification = contactName[i].parentNode.getElementsByClassName("view-notification")[0];
    		if(viewNotification != null){
    			contactName[i].parentNode.removeChild(viewNotification);

				const sideBarMessageNotification = document.getElementsByClassName("side-nav-message-notification")[0];

				if(sideBarMessageNotification != null){
					sideBarMessageNotification.parentNode.removeChild(sideBarMessageNotification);
				}
    		}
    	}
    }

	setTimeout(refreshMessage, 1000);
}

const messageInput = document.getElementsByClassName("message-input")[0];
if(messageInput != null){
	messageInput.onkeydown = function(e){
		if (e.key === 'Enter' || e.keyCode === 13) {
			if(messageInput.value.length > 0){
		        let formData = new FormData();
		        const urlParams = new URLSearchParams(window.location.search);
		        const accountPseudo = urlParams.get('direct');

		        formData.append('receiver', accountPseudo);
		        formData.append('message', messageInput.value);
		        fetch('php/api.php', {
		            method: 'POST',
		            body: formData
		        })
		        .then(response => response.text())
		        .then(data => {
		            if(data != ""){
		            	const parsedData = JSON.parse(data);		
		            	messageInput.value = "";
						messageContent.insertAdjacentHTML('beforeend', parsedData);
						messageContent.scrollTo(0, messageContent.scrollHeight);
		            }
		        });
			}
		}
	}
}

let lastScroll = 0;
function startPageMessageCall() {

	const scrollPosition = messageContent.scrollTop;
	const tolerance = 40;

	if (scrollPosition - tolerance  < 0) {
		const lastMessage = document.getElementsByClassName("message-message")[0];

		let formData = new FormData();
	    const urlParams = new URLSearchParams(window.location.search);
	    const accountPseudo = urlParams.get('direct');

	    formData.append('receiver', accountPseudo);

	    if(lastMessage != null && lastMessage.getAttribute("name")){
	    	formData.append('date', lastMessage.getAttribute("name"));
	    }

	    fetch('php/api.php', {
	        method: 'POST',
	        body: formData
	    })
	    .then(response => response.text())
	    .then(data => {
	        if(data != ""){
	        	const parsedData = JSON.parse(data);

	        	if(parsedData != ""){
					messageContent.insertAdjacentHTML('afterbegin', parsedData);
				}
			}
		});
	}
}

if(messageContent != null){
	messageContent.addEventListener("scroll", function(){
	    const now = Date.now();

	    if(now - lastScroll >= 100) {
	    	startPageMessageCall();
	        lastScroll = now;
	    }
	});
}

//-----------------------------------------\\

const newContactMenu = document.getElementsByClassName("message-popup-contact-background")[0];
if(newContactMenu != null){

	const newContact = document.getElementsByClassName("contact-new")[0];
	if(newContact != null){
		newContact.onclick = function(){
			newContactMenu.style.display = "block";
		}
	}

	const newContactMenuClose = document.getElementsByClassName("message-popup-contact-close")[0];
	if(newContactMenuClose != null){
		newContactMenuClose.onclick = function(){
			newContactMenu.style.display = "none";
		}
	}
}

let contactTypingTimer;
const contactSearchInput = document.getElementsByClassName("message-popup-contact-input")[0];
const contactSearchResult = document.getElementsByClassName("message-popup-contact-list")[0];

function addResultContact(profile, pseudo){
    const searchAccount = document.createElement("div");
    searchAccount.classList.add("search-account");

    const accountLink = document.createElement("a");
    accountLink.href = "message.php?direct=" + pseudo;
    
    const accountProfile = document.createElement("img");
    accountProfile.src = profile;

    const accountPseudo = document.createElement("span");
    accountPseudo.textContent = pseudo;

    accountLink.appendChild(accountProfile);
    accountLink.appendChild(accountPseudo);

    searchAccount.appendChild(accountLink);

    contactSearchResult.appendChild(searchAccount);
}

function searchContact(){
    let formData = new FormData();
    formData.append('search', contactSearchInput.value);
    fetch('php/api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        contactSearchResult.innerHTML = '';
        if(data != ""){
            const parsedData = JSON.parse(data);
            for(let i = 0; i < parsedData.length; i++){
                addResultContact(parsedData[i]['profile'], parsedData[i]['pseudo']);
            }
        }else{
            const error = document.createElement("p");
            error.classList.add("search-error");
            error.textContent = "Nous avons pas trouvé de compte";
            contactSearchResult.appendChild(error);
        }
    })
}

contactSearchInput.onkeydown = function(){
    clearTimeout(contactTypingTimer);
    contactTypingTimer = setTimeout(searchContact, 500);
}