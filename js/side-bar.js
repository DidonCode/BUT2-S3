var researchPanel = document.getElementsByClassName("side-nav-sub-research")[0];
var notificationPanel = document.getElementsByClassName("side-nav-sub-notification")[0];

var subPanel = document.getElementsByClassName("side-nav-sub")[0];
var sideBar = document.getElementsByClassName("side-nav-bar")[0];
var sideNavButton = sideBar.getElementsByClassName("side-nav-button");
var titleSpan = sideBar.getElementsByTagName("span");
var logoTitle = sideBar.getElementsByClassName("logo-title")[0];
var iconTitle = sideBar.getElementsByClassName("icon-title")[0];

subPanel.style.display = "block";

function openSearchSide(){
	if(subSideBarIsOpen() && notificationPanel.style.display == "block"){
		renderSearchSide(true);
	}
	else if(!subSideBarIsOpen()){
		subSideBarOpen(true);
		renderSearchSide(true);
	}else{
		subSideBarOpen(false);
	}
}

function openNotificationSide(){
	if(subSideBarIsOpen() && researchPanel.style.display == "block"){
		renderNotificationSide(true);
	}
	else if(!subSideBarIsOpen()){
		subSideBarOpen(true);
		renderNotificationSide(true);
	}else{
		subSideBarOpen(false);
	}
}

function renderSearchSide(open){
	if(!open){
		researchPanel.style.display = "none";
		notificationPanel.style.display = "block";
	}else{
		researchPanel.style.display = "block";
		notificationPanel.style.display = "none";
	}	
}

function renderNotificationSide(open){
	if(!open){
		researchPanel.style.display = "block";
		notificationPanel.style.display = "none";
	}else{
		researchPanel.style.display = "none";
		notificationPanel.style.display = "block";
	}	
}

function renderMenuButton(){
	for(var i = 0; i < titleSpan.length; i++){
		titleSpan[i].style.display = "";
		sideNavButton[i].style.width = "";
	}
	iconTitle.style.display = "none";
	logoTitle.style.display = "block";
	iconTitle.style.animation = "disappear 0.4s linear";
	logoTitle.style.animation = "appear 0.4s linear";
}

function subSideBarOpen(open){
	subPanel.style.display = "";
	if(!open){ //Close
		subPanel.style.width = "0px";
		sideBar.style.marginRight = "";
		sideBar.style.minWidth = "";
		sideBar.addEventListener('transitionend', renderMenuButton);
	}
	else{ //Open
		subPanel.style.width = "";
		sideBar.style.marginRight = "340px";
		for(var i = 0; i < titleSpan.length; i++){
			titleSpan[i].style.display = "none";
			sideNavButton[i].style.width = "45px";
		}
		sideBar.style.minWidth = "50px";
		logoTitle.style.animation = "disappear 0.4s linear";
		sideBar.removeEventListener('transitionend', renderMenuButton);
		setTimeout(() => {
			logoTitle.style.display = "none";
			iconTitle.style.display = "block";
			iconTitle.style.animation = "appear 0.4s linear";
		}, 380);
	}
}

function subSideBarIsOpen(){
	var subPanel = document.getElementsByClassName("side-nav-sub")[0];
	if(subPanel.style.width == "0px"){
		return false;
	}else{
		return true;
	}
}