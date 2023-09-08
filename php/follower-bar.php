<style>
	.follower-bar{
		width: 200px;
		height: 400px;
		padding: 10px;
		border: 2px solid black;
		border-top: none;
		border-right: none;
		font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
	}

	.follower-header, .follower-suggestion-header{
		display: table-row;
		vertical-align: middle;
	}

	.follower-suggestion-header{
		margin-top: 20px;
	}

	.follower-header-profil{
		display: table-cell;
		vertical-align: middle;
		border-radius: 50%;
		width: 40px;
		height: 40px;
		margin-right: 10px;
	}

	.follower-header-information{
		display: table-cell;
		vertical-align: middle;
	}

	.follower-publisher{
		margin: 0px;
		font-weight: 600;
	}

	.follower-fullName{
		margin: 0px;
		font-size: 0.8em;
	}
</style>

<div class="follower-bar">
	<div class="follower-header">
		<img src="" class="follower-header-profil">
		<div class="follower-header-information">
			<p class="follower-publisher">rugvyenfrance</p>
			<p class="follower-fullName">Rugby France</p>
		</div>
	</div>

	<h4 style="color: rgba(0, 0, 0, 0.05);">Suggestions pour vous</h4>

	<div class="follower-content">
		<?php
			for($i = 0; $i < 5; $i++){
				echo '
				<div class="follower-suggestion-header">
					<img src="" class="follower-header-profil">
					<div class="follower-header-information">
						<p class="follower-publisher">rugvyenfrance</p>
						<p class="follower-fullName">Rugby France</p>
					</div>
				</div>
				';
			}
		?>
	</div>
</div>