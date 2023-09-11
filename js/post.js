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
		openView(post[i], true);
	}

	var commentCloseButton = post[i].getElementsByClassName("post-popup-close")[0];
	commentCloseButton.onclick = function(){
		openView(post[i], false);
		if(post[i].getAttribute('id') == "open"){
			post[i].setAttribute('id', '');
		}
	}

	if(post[i].getAttribute('id') === "open"){
		openView(post[i], true);
	}

	// var commentBackground = post[i].getElementsByClassName("post-popup-background")[0];
	// commentBackground.onclick = function(){
	// 	openView(post[i], false);
	// }
}

window.addEventListener('beforeunload', function (e) {
	var xhr = new XMLHttpRequest();
	var post = document.getElementsByClassName("post");
	var likes = [];
	for(let i = 0; i < post.length; i++){
		var likeButton = post[i].getElementsByClassName("post-action-like")[0];
		var iconButton = likeButton.getElementsByClassName("post-like-style");
		var postId = post[i].getAttribute('name');

		if(iconButton[0].style.display == "none"){
			likes.push([postId, 1]);
		}else{
			likes.push([postId, 0]);
		}
	}

	sessionStorage.setItem('likes', likes);

	xhr.open('POST', 'traitement_depart.php', false);
	xhr.send();
});

function openView(post, open){
	var body = document.getElementsByTagName("body")[0];
	var postPopup = post.getElementsByClassName("post-popup")[0];
	var postPopupBackground = post.getElementsByClassName("post-popup-background")[0];
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


if(window.history.replaceState){
	window.history.replaceState(null, null, window.location.href);
}

console.log(sessionStorage.getItem('likes'));