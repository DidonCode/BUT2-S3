const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

if(signUpButton != null && signInButton != null && container != null){
	const side = sessionStorage.getItem('login-side');

	if(side === 'right'){
		changeToRight();
	}

	if(side === 'left'){
		changeToLeft();
	}

	signUpButton.addEventListener('click', () => {
		changeToRight();
		sessionStorage.setItem('login-side', 'right');
	});

	signInButton.addEventListener('click', () => {
		changeToLeft();
		sessionStorage.setItem('login-side', 'left');
	});

	function changeToRight(){
		container.classList.add("right-panel-active");
	}

	function changeToLeft(){
		container.classList.remove("right-panel-active");
	} 
}

const signinForm = document.getElementById('signinForm');
if(signinForm != null){
	let email = signinForm.querySelector("[name='email']");
	let pseudo = signinForm.querySelector("[name='pseudo']");
	let fullName = signinForm.querySelector("[name='fullName']");

	signinForm.onsubmit = function(){
		sessionStorage.setItem('email', email.value);
		sessionStorage.setItem('pseudo', pseudo.value);
		sessionStorage.setItem('fullName', fullName.value);
	}

	const error = signinForm.getElementsByClassName('error')[0];
	if(error != null){
		email.value = sessionStorage.getItem('email');
		pseudo.value = sessionStorage.getItem('pseudo');
		fullName.value = sessionStorage.getItem('fullName');
	}
}