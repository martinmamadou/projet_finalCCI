

        document.addEventListener('DOMContentLoaded', function() {
            let options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            let observer = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        observer.unobserve(entry.target); // Stop observing once animated
                    }
                });
            }, options);

            let elements = document.querySelectorAll('.anim');
            console.log(elements)
            elements.forEach(element => {
                observer.observe(element);
            });
        });