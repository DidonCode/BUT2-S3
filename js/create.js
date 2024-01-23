let effectStrength = 50;
let effectType = "";

function changeEffectStrength(element){
	effectStrength = element.value;
	setModification();
}

function changeEffectType(type){
	effectType = type;
	setModification();
}

function setModification(){
	if(effectType !== ""){
		const preview = document.getElementsByClassName("effect-preview")[0];
		preview.style.filter = effectType + "(" + effectStrength + "%)";
	}
}

const uploadButton = document.getElementsByClassName("post-publish")[0];
const effectPost = document.getElementsByClassName("effect-post")[0];
const effectVideo = document.getElementsByClassName("effect-video")[0];
const informationPost = document.getElementsByClassName("information-post")[0];
const inputFile = document.getElementsByClassName("post-content")[0];
const imagesPreview = document.getElementsByClassName("effect-preview-select");
const effectPreview = document.getElementsByClassName("effect-preview");
const uploadFile = document.getElementsByClassName("open-post-content")[0];

uploadFile.addEventListener('click', function(){
	inputFile.click();
});

inputFile.addEventListener('change', function() {
	const selectedFile = inputFile.files[0];
	
	if(selectedFile){
		const url = URL.createObjectURL(selectedFile);

		if(selectedFile.name.match(/\.(png|jpeg|jpg|gif)$/i)) {
			effectVideo.style.display = "none";
			effectPost.style.display = "block";
			effectPost.style.animation = "appear 0.8s linear";
			setTimeout(() => {
				informationPost.style.animation = "appear 0.8s linear";
				informationPost.style.display = "block";
			}, 800);
			for(let i = 0; i < imagesPreview.length; i++){
				imagesPreview[i].getElementsByTagName("img")[0].src = url;
			}
			effectPreview[0].src = url;
			effectPreview[1].src = "#";
		}

		if(selectedFile.name.match(/\.(mp4|)$/i)) {
			effectVideo.style.display = "block";
			effectPost.style.display = "none";
			informationPost.style.animation = "appear 0.8s linear";
			informationPost.style.display = "block";
			for(let i = 0; i < imagesPreview.length; i++){
				imagesPreview[i].getElementsByTagName("img")[0].src = "#";
			}
			effectPreview[0].src = "#";
			effectPreview[1].src = url;
		}
	}
});

uploadButton.addEventListener('click', function () {
	const canvas = document.createElement('canvas');
	const context = canvas.getContext('2d');

	canvas.width = effectPreview[0].naturalWidth;
	canvas.height = effectPreview[0].naturalHeight;

	context.clearRect(0, 0, canvas.width, canvas.height);
	context.filter = effectPreview[0].style.filter;
	context.drawImage(effectPreview[0], 0, 0);

	const dataURL = canvas.toDataURL('image/png');
	document.getElementById("imageData").value = dataURL;
});