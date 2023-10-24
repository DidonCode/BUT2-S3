//SETTINGS//
document.addEventListener("DOMContentLoaded", function () {
    const menuButton = document.getElementById("menuButton");
    const contextMenu = document.getElementById("contextMenu");

    menuButton.addEventListener("click", function (event) {
        event.stopPropagation();
        contextMenu.style.display = contextMenu.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function () {
        contextMenu.style.display = "none";
    });

    contextMenu.addEventListener("click", function (event) {
        event.stopPropagation(); // Empêche la fermeture du menu au clic à l'intérieur du menu.
    });
});
