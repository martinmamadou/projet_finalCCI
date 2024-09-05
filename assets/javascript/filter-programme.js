
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-button');
    const programmeItems = document.querySelectorAll('.programme-item');
    console.log(filterButtons)
    const searchInput = document.getElementById("myInput");

    function filterProgrammes() {
        // Récupère la valeur de la barre de recherche en majuscules
        const filter = searchInput.value.toUpperCase();
        // Récupère le type de programme sélectionné ou 'all' par défaut
        const selectedProType = document.querySelector('.filter-button.act')?.getAttribute('data-protype') || 'all';
        
        programmeItems.forEach(item => {
            // Récupère le nom du programme pour le filtrage
            const programmeName = item.querySelector('h2').textContent.toUpperCase(); // Correction: recherche sur le titre
            const programmeType = item.getAttribute('data-protype');
            console.log(programmeType)
            
            // Vérifie si le programme correspond à la recherche et au filtre de catégorie
            const matchesFilter = programmeName.indexOf(filter) > -1;
            const matchesType = selectedProType === 'all' || selectedProType === programmeType;

            // Affiche ou masque les programmes selon les correspondances
            if (matchesFilter && matchesType) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Gestion du clic sur les boutons de filtre
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('act')); // Retire la classe 'act' des autres boutons
            this.classList.add('act'); // Ajoute la classe 'act' au bouton cliqué
            filterProgrammes(); // Applique le filtrage
        });
    });

    // Gestion de la recherche en temps réel
    searchInput.addEventListener('keyup', filterProgrammes);

    // Initialisation avec tous les programmes visibles
    filterProgrammes();
});

