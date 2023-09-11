var researchPanel = document.getElementsByClassName("side-nav-sub-research")[0];
var notificationPanel = document.getElementsByClassName("side-nav-sub-notification")[0];

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

function subSideBarOpen(open){
	var subPanel = document.getElementsByClassName("side-nav-sub")[0];
	var sideBar = document.getElementsByClassName("side-nav-bar")[0];
	var sideNavButton = sideBar.getElementsByClassName("side-nav-button");
	var titleSpan = sideBar.getElementsByTagName("span");
	var logoTitle = sideBar.getElementsByClassName("logo-title")[0];
	var iconTitle = sideBar.getElementsByClassName("icon-title")[0];

	if(!open){ //Close
		subPanel.style.width = "0px";
		for(var i = 0; i < titleSpan.length; i++){
			titleSpan[i].style.display = "";
			sideNavButton[i].style.width = "";
		}
		sideBar.style.width = "";
		iconTitle.style.animation = "disappear 0.4s linear";
		setTimeout(() => {
			iconTitle.style.display = "none";
			logoTitle.style.display = "block";
			logoTitle.style.animation = "appear 0.4s linear";
		}, "380");
	
	}
	else{ //Open
		subPanel.style.width = "";
		for(var i = 0; i < titleSpan.length; i++){
			titleSpan[i].style.display = "none";
			sideNavButton[i].style.width = "45px";
		}
		sideBar.style.width = "50px";
		logoTitle.style.animation = "disappear 0.4s linear";
		setTimeout(() => {
			logoTitle.style.display = "none";
			iconTitle.style.display = "block";
			iconTitle.style.animation = "appear 0.4s linear";
		}, "380");
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