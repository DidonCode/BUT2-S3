// Sélectionnez les éléments de la barre de navigation
const profileNavItem = document.getElementById('profile');
const accountNavItem = document.getElementById('account');

// Sélectionnez les modules
const profileModule = document.getElementById('profileContent');
const accountModule = document.getElementById('accountContent');

// Sélectionnez la pop-up
const popup = document.getElementById('popup');
const closePopupButton = document.getElementById('close-popup');
const popupTitle = document.getElementById('popup-title');
const popupTextarea = document.getElementById('popup-textarea');
const popupSaveButton = document.getElementById('popup-save-button');

// Ajoutez des gestionnaires d'événements pour les éléments de navigation
profileNavItem.addEventListener('click', () => {
    profileModule.style.display = 'block';
    accountModule.style.display = 'none';
    popup.style.display = 'none'; // Assurez-vous de masquer la pop-up lorsque vous changez de module
});

accountNavItem.addEventListener('click', () => {
    profileModule.style.display = 'none';
    accountModule.style.display = 'block';
    popup.style.display = 'none'; // Assurez-vous de masquer la pop-up lorsque vous changez de module
});

// Ajoutez des gestionnaires d'événements pour les sous-modules (ouverture de la pop-up)
profileModule.addEventListener('click', () => {
    popup.style.display = 'block';
    popupTitle.textContent = 'Changer de Nom';
    popupTextarea.value = ''; // Réinitialisez le contenu du textarea si nécessaire
});

accountModule.addEventListener('click', () => {
    popup.style.display = 'block';
    popupTitle.textContent = 'Compte Bloqué';
    popupTextarea.value = ''; // Réinitialisez le contenu du textarea si nécessaire
});

// Ajoutez un gestionnaire d'événements pour fermer la pop-up
closePopupButton.addEventListener('click', () => {
    popup.style.display = 'none';
});

// Ajoutez un gestionnaire d'événements pour le bouton "Sauvegarder"
popupSaveButton.addEventListener('click', () => {
    const content = popupTextarea.value;
    // Vous pouvez utiliser "content" comme vous le souhaitez, par exemple, pour enregistrer les données.
    // Pour l'instant, nous n'implémentons que la fermeture de la pop-up.
    popup.style.display = 'none';
});
