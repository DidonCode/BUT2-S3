<style>
	.post{
		margin-top: 30px;
		width: 500px;
		padding: 20px;
		border: 1px solid darkgray;
		border-radius: 1em;
		user-select: none;
		box-shadow: 10px 10px 14px 0px rgba(199,199,199,0.75);
	}

	.post-header{
		display: table-row;
		vertical-align: middle;
	}

	.post-header-profil{
		display: table-cell;
		vertical-align: middle;
		border-radius: 50%;
		width: 40px;
		height: 40px;
		margin-right: 10px;
	}

	.post-header-information{
		display: table-cell;
		vertical-align: middle;
	}

	.post-publisher{
		margin: 0px;
		font-weight: 600;
	}

	.post-spot{
		margin: 0px;
		font-size: 0.8em;
	}

	.post-content{
		width: 100%;
		padding: 10px 0px 10px 0px;
	}

	.post-content img{
		width: 100%;
		max-height: 100%;
		border-radius: 0.5em;
	}

	.post-content video{
		width: 100%;
		max-height: 100%;
		border-radius: 0.5em;
	}

	.post-like-style{
		display: block;
	}

	.post-footer{

	}

	.post-actions{
		display: flex;
	}

	.post-actions button{
		border: none;
		background-color: transparent;
	}

	.post-like{
		font-size: 0.9em;
		font-weight: 600;
		line-height: 10px;
	}

	.post-description{
		line-height: 10px;
		word-break: break-all;
	}

	@keyframes like {
		0%{ transform: scale(1); }
		50%{ transform: scale(1.3); }
		100%{ transform: scale(1); }
	}

	@keyframes unlike {
		0%{ transform: scale(1); }
		50%{ transform: scale(0.7); }
		100%{ transform: scale(1); }
	}
</style>

<?php

function printPost($accountName, $accountProfil, $postContent, $postType, $postSpot, $postLike, $postDescription) {

	echo '
		<div class="post">
			<div class="post-header">
				<img src="' . $accountProfil .'" class="post-header-profil">
				<div class="post-header-information">
					<p class="post-publisher">' . $accountName . '</p>
					<p class="post-spot">'. $postSpot . '</p>
				</div>
			</div>
			<div class="post-content">';
				if($postType == "image"){
					echo '<img src="' . $postContent . '">';
				}
				else if($postType == "video"){
					echo '<video muted autoplay loop>
						<source src="' . $postContent . '" type="video/mp4"/>
						</video>
					';
				};
			echo'
			</div>
			<div class="post-footer">
				<div class="post-actions">
					<button class="post-action-like">
						<svg height="24" width="24" viewBox="0 0 24 24" class="post-like-style">
								<path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 	2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 	6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 	45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>

						</svg>
						<svg height="24" width="24" viewBox="0 0 48 48" color="rgb(255, 48, 64)" fill="rgb(255, 48, 64)" class="post-like-style">
								<path d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"/>
						</svg>
					</button>
		
					<button>
						<svg height="24" width="24" viewBox="0 0 24 24">
							<path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"/>
						</svg>
					</button>
				</div>
				<p class="post-like"><span class="post-like-counter">' .$postLike . '</span> J\'aime</p>
				<p class="post-description"><span style="font-weight: 600;">' . $accountName . '</span> ' . $postDescription . '</p>
			</div>
		</div>';
	}

 
	printPost("DidonCode","images/r.jpg","images/Minecraft.jpg","image","Nevers", "265", "Premier post !");
	printPost("Killian","images/civilisation.jpg","images/NyanCat.mp4","video","Nevers", "12","NyanCat !");
?>

<script>
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
	}
</script>