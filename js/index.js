let lastScroll = 0;

function endPageCall() {

	const container = document.getElementsByClassName("container")[0];
	const totalHeight = document.documentElement.scrollHeight;
	const scrollPosition = window.scrollY || window.pageYOffset;
	const windowHeight = window.innerHeight;
	const tolerance = 300;

	if (totalHeight - (scrollPosition + windowHeight) < tolerance) {
		let formData = new FormData();
		formData.append('getPost', '');

		let existingPost = [];
		const posts = document.getElementsByClassName("post");
		if(posts != null){
			for(let i = 0; i < posts.length; i++){
				existingPost.push(posts[i].getAttribute("name"));
			}

			formData.append('existingPost', existingPost);
		}else{
			formData.append('existingPost', null);
		}

		fetch('php/api.php', {
			method: 'POST',
			body: formData
		})
		.then(response => response.text())
		.then(data => {
			if(data != ""){
				const parsedData = JSON.parse(data);
				for(let i = 0; i < parsedData.length; i++){
					container.insertAdjacentHTML('beforeend', parsedData[i]);
				}
				loadEventPosts();
			}
		})
	}
}

window.addEventListener("scroll", function(){
    const now = Date.now();

    if(now - lastScroll >= 100) {
    	endPageCall();
        lastScroll = now;
    }
});