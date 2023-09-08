var post = document.getElementsByClassName("post");
for(let i = 0; i < post.length; i++){
	var likeButton = post[i].getElementsByClassName("post-action-like")[0];
	likeButton.onclick = function(){
		var likeButton = post[i].getElementsByClassName("post-action-like")[0];
		var likeCounter = post[i].getElementsByClassName("post-like-counter")[0];
		var iconButton = likeButton.getElementsByClassName("post-like-style");

		if(iconButton[0].style.display == "none"){
			iconButton[0].style.display = "block";
			iconButton[1].style.display = "none";
			iconButton[0].style.animation = "unlike 0.4s ease-in-out";
			likeCounter.innerText = parseInt(likeCounter.innerText) - 1;
		}
		else{
			iconButton[0].style.display = "none";
			iconButton[1].style.display = "block";
			iconButton[1].style.animation = "like 0.4s ease-in-out";
			likeCounter.innerText = parseInt(likeCounter.innerText) + 1;
		}
	}

	var commentButton = post[i].getElementsByClassName("post-action-comment")[0];
	commentButton.onclick = function(){
		var postPopup = post[i].getElementsByClassName("post-popup")[0];
		var postPopupBackground = post[i].getElementsByClassName("post-popup-background")[0];
		var body = document.getElementsByTagName("body")[0];
		postPopup.style.display = "flex";
		postPopupBackground.style.display = "block";
		body.style.overflowY = "hidden";
	}

	var commentCloseButton = post[i].getElementsByClassName("post-popup-close")[0];
	commentCloseButton.onclick = function(){
		var postPopup = post[i].getElementsByClassName("post-popup")[0];
		var postPopupBackground = post[i].getElementsByClassName("post-popup-background")[0];
		var body = document.getElementsByTagName("body")[0];
		postPopup.style.display = "none";
		postPopupBackground.style.display = "none";
		body.style.overflowY = "visible";
	}
}