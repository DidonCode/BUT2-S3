function loadEventPosts(){
	const post = document.getElementsByClassName("post");

	if(post.length > 0){
		for(let i = 0; i < post.length; i++){
			const likeButtons = post[i].getElementsByClassName("post-action-like");
			for(let j = 0; j < likeButtons.length; j++){
				likeButtons[j].onclick = function(){
					if(localStorage.getItem('validSession') === null || localStorage.getItem('validSession') === false){
						window.location.href = "form.php";
					}

					for(let k = 0; k < likeButtons.length; k++){
						let likeButton = null;
						if(j == 0){
							likeButton = post[i].getElementsByClassName("post-action-like")[j + k];
						}else{
							likeButton = post[i].getElementsByClassName("post-action-like")[j - k];
						}

						const likeCounter = post[i].getElementsByClassName("post-like-counter")[0];

						if(likeButton != null){
							const iconButton = likeButton.getElementsByClassName("post-like-style");

							if(iconButton[0].style.display == "none"){
								iconButton[1].style.display = "none";
								iconButton[0].style.display = "block";
								iconButton[0].style.animation = "unlike 0.4s ease-in-out";
								if(k == 0 && likeCounter != null){
									likeCounter.innerText = parseInt(likeCounter.innerText) - 1;
								}
							}
							else{
								iconButton[0].style.display = "none";
								iconButton[1].style.display = "block";
								iconButton[1].style.animation = "like 0.4s ease-in-out";
								if(k == 0 && likeCounter != null){
									likeCounter.innerText = parseInt(likeCounter.innerText) + 1;
								}
							}

						}
					}
				}
			}

			const muteButton = post[i].getElementsByClassName("mute-sound-post");
			for(let j = 0; j < muteButton.length; j++){
				muteButton[j].onclick = function(){
					for(let k = 0; k < likeButtons.length; k++){
						let button = null;
						if(j == 0){
							button = post[i].getElementsByClassName("mute-sound-post")[j + k];
						}else{
							button = post[i].getElementsByClassName("mute-sound-post")[j - k];
						}
						const icons = button.getElementsByTagName("svg");
						const video = post[i].getElementsByTagName("video")[0];

						if(icons[0].style.display == "none"){
							icons[1].style.display = "none";
							icons[0].style.display = "block";
							if(k == 0){
								video.muted = true;
							}
						}else{
							icons[0].style.display = "none";
							icons[1].style.display = "block";
							if(k == 0){
								video.muted = false;
							}
						}
					}
				}
			}

			const commentButton = post[i].getElementsByClassName("post-action-comment")[0];
			if(commentButton != null){
				commentButton.onclick = function(){
					openPopupView(post[i], true);
				}
			}

			const commentButtonPopup = post[i].getElementsByClassName("post-action-comment")[1];
			if(commentButtonPopup != null){
				commentButtonPopup.onclick = function(){
					const commentInput = post[i].getElementsByClassName("post-popup-comment-input")[0];
					commentInput.focus();
				}
			}

			const moreOption = post[i].getElementsByClassName("post-header-option");
			if(moreOption != null){
				for(let j = 0; j < moreOption.length; j++){
					moreOption[j].onclick = function(){
						openOptionView(post[i], true);
					}
				}
			}

			const moreOptionClose = post[i].getElementsByClassName("post-popup-option-close")[0];
			if(moreOptionClose != null){
				moreOptionClose.onclick = function(){
					openOptionView(post[i], false);
				}
			}

			const postContentStat = post[i].getElementsByClassName("post-preview-stat")[0];
			if(postContentStat != null){
				postContentStat.onclick = function(){
					openPopupView(post[i], true);
				}
			}

			const commentCloseButton = post[i].getElementsByClassName("post-popup-close")[0];
			if(commentCloseButton != null){
				commentCloseButton.onclick = function(){
					openPopupView(post[i], false);
				}
			}

			const moreOptionReport = post[i].getElementsByClassName("post-popup-option-report")[0];
			if(moreOptionReport != null){
				moreOptionReport.onclick = function(){
					let formData = new FormData();
					formData.append('postReport', post[i].getAttribute('name'));
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
			        });
			        openOptionView(post[i], false);
				}
			}

			const moreOptionDelete = post[i].getElementsByClassName("post-popup-option-delete")[0];
			if(moreOptionDelete != null){
				moreOptionDelete.onclick = function(){
					let formData = new FormData();
					formData.append('postDelete', post[i].getAttribute('name'));
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
					});
					openOptionView(post[i], false);
				}
			}
		}

		window.addEventListener('beforeunload', function (e) {
			window.addEventListener('beforeunload', function (e) {
				e.returnValue = "";
			});
			
			const post = document.getElementsByClassName("post");
			let likes = [];
			for(let i = 0; i < post.length; i++){
				const likeButton = post[i].getElementsByClassName("post-action-like")[0];
				const iconButton = likeButton.getElementsByClassName("post-like-style");
				const postId = post[i].getAttribute('name');

				if(iconButton[0].style.display == "none"){
					likes.push([postId, 1]);
				}else{
					likes.push([postId, -1]);
				}
			}

			let formData = new FormData();
			formData.append('likes', likes.toString());
			navigator.sendBeacon('php/api.php', formData);

			window.removeEventListener('beforeunload', function (e) {
				e.returnValue = "";
			});
		});

		function openPopupView(post, open){
			const body = document.getElementsByTagName("body")[0];
			const postPopup = post.getElementsByClassName("post-popup")[0];
			const postPopupBackground = post.getElementsByClassName("post-popup-background")[0];
			if(open){
				postPopup.style.display = "flex";
				postPopupBackground.style.display = "block";
				body.style.overflowY = "hidden";
				window.history.pushState('data', '', "post.php?post=" + post.getAttribute('name'));
			}
			else{
				postPopup.style.display = "none";
				postPopupBackground.style.display = "none";
				body.style.overflowY = "visible";
				window.history.back();
			}
		}
	}else{

		const postPopup = document.getElementsByClassName("post-popup");

		if(postPopup.length > 0){
			for(let i = 0; i < postPopup.length; i++){
				const likeButton = postPopup[i].getElementsByClassName("post-action-like")[0];

				if(likeButton != null){
					likeButton.onclick = function(){
						if(localStorage.getItem('validSession') === null || localStorage.getItem('validSession') === false){
							window.location.href = "form.php";
						}

						const likeButton = postPopup[i].getElementsByClassName("post-action-like")[0];
						const iconButton = likeButton.getElementsByClassName("post-like-style");

						if(iconButton[0].style.display == "none"){
							iconButton[1].style.display = "none";
							iconButton[0].style.display = "block";
							iconButton[0].style.animation = "unlike 0.4s ease-in-out";
						}
						else{
							iconButton[0].style.display = "none";
							iconButton[1].style.display = "block";
							iconButton[1].style.animation = "like 0.4s ease-in-out";
						}
					}
				}

				const muteButton = postPopup[i].getElementsByClassName("mute-sound-post");
				if(muteButton != null){
					for(let j = 0; j < muteButton.length; j++){
						if(muteButton[j] != null){
							muteButton[j].onclick = function(){
								const button = postPopup[i].getElementsByClassName("mute-sound-post");
								const icons = button[0].getElementsByTagName("svg");
								const video = postPopup[i].getElementsByTagName("video")[0];
								if(video != null){
									if(video.muted){
										video.muted = false;
										icons[0].style.display = "none";
										icons[1].style.display = "block";
									}else{
										video.muted = true;
										icons[1].style.display = "none";
										icons[0].style.display = "block";
									}
								}
							}
						}
					}
				}

				const commentButtonPopup = postPopup[i].getElementsByClassName("post-action-comment")[0];
				if(commentButtonPopup != null){
					commentButtonPopup.onclick = function(){
						const commentInput = postPopup[i].getElementsByClassName("post-popup-comment-input")[0];
						commentInput.focus();
					}
				}

				const moreOption = postPopup[i].getElementsByClassName("post-popup-header-option")[0];
				if(moreOption != null){
					moreOption.onclick = function(){
						openOptionView(document, true);
					}
				}
		
				const moreOptionClose = document.getElementsByClassName("post-popup-option-close")[0];
				if(moreOptionClose != null){
					moreOptionClose.onclick = function(){
						openOptionView(document, false);
					}
				}

				const moreOptionReport = document.getElementsByClassName("post-popup-option-report")[0];
				if(moreOptionReport != null){
					moreOptionReport.onclick = function(){
						let formData = new FormData();
						formData.append('postReport', postPopup[i].getAttribute('name'));
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
				        });
				        openOptionView(document, false);
					}
				}

				const moreOptionDelete = document.getElementsByClassName("post-popup-option-delete")[0];
				if(moreOptionDelete != null){
					moreOptionDelete.onclick = function(){
						let formData = new FormData();
						formData.append('postDelete', postPopup[i].getAttribute('name'));
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
				        });
				        openOptionView(document, false);
					}
				}
			}

			window.addEventListener('beforeunload', function (e) {
				window.addEventListener('beforeunload', function (e) {
					e.returnValue = "";
				});

				const post = document.getElementsByClassName("post-popup");
				let likes = [];
				for(let i = 0; i < post.length; i++){
					const likeButton = post[i].getElementsByClassName("post-action-like")[0];
					const iconButton = likeButton.getElementsByClassName("post-like-style");
					const postId = post[i].getAttribute('name');

					if(iconButton[0].style.display == "none"){
						likes.push([postId, 1]);
					}else{
						likes.push([postId, 0]);
					}
				}

				let formData = new FormData();
				formData.append('likes', likes.toString());
				navigator.sendBeacon('php/api.php', formData);

				window.removeEventListener('beforeunload', function (e) {
					e.returnValue = "";
				});
			});
		}
	}

	function openOptionView(post, open){
		const body = document.getElementsByTagName("body")[0];
		const postPopup = post.getElementsByClassName("post-popup-option")[0];

		const postPopupBackground = post.getElementsByClassName("post-popup-option-background")[0];
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
}

loadEventPosts();