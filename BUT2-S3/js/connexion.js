const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

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