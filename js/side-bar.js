const researchPanel = document.getElementsByClassName("side-nav-sub-research")[0];
const notificationPanel = document.getElementsByClassName("side-nav-sub-notification")[0];

const subPanel = document.getElementsByClassName("side-nav-sub")[0];
const sideBar = document.getElementsByClassName("side-nav-bar")[0];
const sideBarFixed = document.getElementsByClassName("side-nav-fixed")[0];

if(sideBar != null){

	const sideNavButton = sideBar.getElementsByClassName("side-nav-button");
	const logoTitle = sideBar.getElementsByClassName("logo-title")[0];
	const iconTitle = sideBar.getElementsByClassName("icon-title")[0];

	const notificationIcon = sideBar.getElementsByClassName("notification-icon");
	const researchIcon = sideBar.getElementsByClassName("research-icon");

	subPanel.style.display = "block";

	function openSearchSide(){
		if(subSideBarIsOpen() && notificationPanel.style.display == "block"){
			renderSearchSide(true);
			renderNotificationSide(false);
		}
		else if(!subSideBarIsOpen()){
			subSideBarOpen(true);
			renderSearchSide(true);
		}else{
			subSideBarOpen(false);
			renderSearchSide(false);
		}
	}

	function openNotificationSide(){
		if(subSideBarIsOpen() && researchPanel.style.display == "block"){
			renderNotificationSide(true);
			renderSearchSide(false);
		}
		else if(!subSideBarIsOpen()){
			subSideBarOpen(true);
			renderNotificationSide(true);
		}else{
			subSideBarOpen(false);
			renderNotificationSide(false);
		}

		const notificationNotification = document.getElementsByClassName("side-nav-notification-notification")[0];
		if(notificationNotification != null){
			notificationNotification.parentElement.removeChild(notificationNotification);

			let formData = new FormData();
			formData.append('viewNotification', 1);
			fetch('php/api.php', {
			    method: 'POST',
			    body: formData
			})
			.then(response => response.text())
			.then(data => {
			})
		}
	}

	function renderSearchSide(open){
		if(!open){
			researchPanel.style.display = "none";

			researchIcon[1].style.display = "none";
			researchIcon[0].style.display = "block";
		}else{
			researchPanel.style.display = "block";

			researchIcon[1].style.display = "block";
			researchIcon[0].style.display = "none";
		}	
	}

	function renderNotificationSide(open){
		if(!open){
			notificationPanel.style.display = "none";

			notificationIcon[1].style.display = "none";
			notificationIcon[0].style.display = "block";
		}else{
			notificationPanel.style.display = "block";

			notificationIcon[1].style.display = "block";
			notificationIcon[0].style.display = "none";
		}
	}

	function renderMenuButton(){
		for(let i = 0; i < sideNavButton.length; i++){
			const titleSpan = sideNavButton[i].getElementsByTagName("span");
			titleSpan[0].style.display = "";
			if(sideNavButton[i] != null){
				sideNavButton[i].style.width = "";
			}
		}

		iconTitle.style.display = "";
		logoTitle.style.display = "";
		if(window.getComputedStyle(sideBar).getPropertyValue('width') === "55px"){
			iconTitle.style.animation = "";
			logoTitle.style.animation = "";
		}else{
			iconTitle.style.animation = "disappear 0.4s linear";
			logoTitle.style.animation = "appear 0.4s linear";
		}

		sideBar.style.transition = "";
	}

	function sideBarOpen(open){
		sideBar.style.transition = "0.8s";
		if(!open){ //Close
			sideBar.style.marginRight = "";
			sideBar.style.minWidth = "";
			sideBarFixed.style.minWidth = "";
			sideBar.addEventListener('transitionend', renderMenuButton);
		}else{
			for(let i = 0; i < sideNavButton.length; i++){
				const titleSpan = sideNavButton[i].getElementsByTagName("span");
				titleSpan[0].style.display = "none";
				if(sideNavButton[i] != null){
					sideNavButton[i].style.width = "45px";
				}
			}
			sideBar.style.minWidth = "55px";
			sideBarFixed.style.minWidth = "55px";
			logoTitle.style.animation = "disappear 0.4s linear";
			logoTitle.style.display = "none";

			sideBar.removeEventListener('transitionend', renderMenuButton);

			if(window.getComputedStyle(sideBar).getPropertyValue('width') === "55px"){
				sideBar.style.marginRight = "";
			}else{
				sideBar.style.marginRight = "195px";
				setTimeout(() => {
					iconTitle.style.display = "block";
					iconTitle.style.animation = "appear 0.4s linear";
				}, 380);
			}
		}
	}

	function subSideBarOpen(open){
		if(!open){ //Close
			subPanel.style.width = "0px";
			sideBarOpen(open);
		}
		else{
			subPanel.style.width = "";
			sideBarOpen(open);
		}
	}

	function subSideBarIsOpen(){
		const subPanel = document.getElementsByClassName("side-nav-sub")[0];
		if(subPanel.style.width == "0px"){
			return false;
		}else{
			return true;
		}
	}

	const sideBarSubMenu = document.getElementById("side-nav-sub-menu");
	if(sideBarSubMenu != null){
		const menu = document.getElementsByClassName("side-nav-sub-menu")[0];

		sideBarSubMenu.addEventListener('click', function (e) {
			menu.style.display = menu.style.display === "block" ? "none" : "block";
		});

		window.addEventListener('resize', function () {
			sideBarSubMenuOpen(false);
		});

		document.addEventListener('click', function (event) {
			var isClickInsideMenu = menu.contains(event.target);
			var isClickInsideButton = sideBarSubMenu.contains(event.target);

			if (!isClickInsideMenu && !isClickInsideButton) {
				sideBarSubMenuOpen(false);
			}
		});
	}

	function sideBarSubMenuOpen(open){
		const menu = document.getElementsByClassName("side-nav-sub-menu")[0];
		if(open){
			menu.style.display = "block";
		}else{
			menu.style.display = "none";
		}
	}

	function toggleDarkMode(){
		const body = document.body;
		if (body.classList.contains('dark-mode')) {
			body.classList.remove('dark-mode');
			localStorage.setItem('dark-mode', false);
		}else {
			body.classList.add('dark-mode');
			localStorage.setItem('dark-mode', true);
		}
	}
}

if(localStorage.getItem('dark-mode') == "true"){
	document.body.classList.add('dark-mode');
}