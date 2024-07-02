let currentDiv = 0;
const divs = document.querySelectorAll('.exercice-container');
console.log(divs)

// Afficher la première div au chargement de la page
divs[currentDiv].classList.remove('hidden');

document.getElementById('suivant').addEventListener('click', function() {
    if (currentDiv < divs.length - 1) {
        divs[currentDiv].classList.add('hidden');
        currentDiv++;
        divs[currentDiv].classList.remove('hidden');
    } else {
        alert('Toutes les divs ont été affichées.');
    }
});
