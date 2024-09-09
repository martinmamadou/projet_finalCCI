document.addEventListener('DOMContentLoaded', function () {
    const exercices = document.querySelectorAll('.exercice-container');
    let currentIndex = 0;
    // Hide all divs except the first one
    exercices.forEach((ex, index) => {
        if (index !== 0) {
            ex.style.display = 'none';
        }
    });
    // Function to show the next div and hide the current one
    function showNextExercice() {
        const currentExercice = exercices[currentIndex];
        const repos = currentExercice.querySelector('.repos');
        const exo = currentExercice.querySelector('.exo');
        if (currentIndex < exercices.length - 1) {
            if (!repos.classList.contains('hidden')) {
                currentExercice.style.display = 'none';
                currentIndex++;
                const nextExercice = exercices[currentIndex];
                nextExercice.style.display = 'block';
                repos.classList.add('hidden');
                exo.classList.remove('hidden');
                startTimerIfPresent(nextExercice);
            } else {
                repos.classList.remove('hidden');
                exo.classList.add('hidden');
                startReposTimer(repos);
            }
        } else {
            currentExercice.style.display = 'none';
            document.querySelector('.resume').classList.remove('hidden');
            document.querySelector('.terminer').classList.remove('hidden');
            document.getElementById('suivant').classList.add('hidden');
            document.querySelector('.ex-img').classList.add('hidden')
        }
    }
    // Function to start the timer if present
    function startTimerIfPresent(exercice) {
        const timerElement = exercice.querySelector('.timer');
        if (timerElement) {
            let time = parseInt(timerElement.textContent);
            const interval = setInterval(() => {
                if (time > 0) {
                    time--;
                    timerElement.textContent = `${time}s`;
                } else {
                    clearInterval(interval);
                }
            }, 1000);
        }
    }
    // Function to start the repos timer
    function startReposTimer(repos) {
        const timerElement = repos.querySelector('.repoTimer');
        if (timerElement) {
            let time = parseInt(timerElement.textContent);
            const interval = setInterval(() => {
                if (time > 0) {
                    time--;
                    timerElement.textContent = `${time}s`;
                } else {
                    clearInterval(interval);
                }
            }, 1000);
        }
    }
    // Add event listener to the button
    document.getElementById('suivant').addEventListener('click', showNextExercice);
    // Start the timer for the first exercice if present
    startTimerIfPresent(exercices[currentIndex]);
});
