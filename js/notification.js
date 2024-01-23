function responceFollow(element, pseudo, responce){
	let formData = new FormData();
	formData.append('account', pseudo);
	formData.append('choice', responce);
	formData.append('notification', parseInt(element.parentElement.getAttribute('name')));
	navigator.sendBeacon('php/api.php', formData);

	const parent = element.parentElement.parentElement;
	parent.removeChild(element.parentElement);
}