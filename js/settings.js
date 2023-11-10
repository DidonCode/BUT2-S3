document.addEventListener('DOMContentLoaded', function () {
    var sidebarItems = document.querySelectorAll('.sidebar li');
    var settingItems = document.querySelectorAll('.setting-item');
    var applyBtn = document.querySelector('.apply-btn');

    sidebarItems.forEach(function (item) {
        item.addEventListener('click', function () {
            var category = item.id;

            settingItems.forEach(function (setting) {
                if (setting.classList.contains(category)) {
                    setting.style.display = 'block';
                } else {
                    setting.style.display = 'none';
                }
            });

            applyBtn.style.display = 'block';
        });
    });

    settingItems.forEach(function (setting) {
        setting.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        var subMenu = setting.querySelector('.sub-menu');
        if (subMenu) {
            setting.addEventListener('click', function () {
                subMenu.style.display = (subMenu.style.display === 'none' || subMenu.style.display === '') ? 'block' : 'none';
            });
        }
    });
});

function applyChanges() {
    alert('Modifications appliquées avec succès!');
}