
        document.addEventListener('DOMContentLoaded', function() {
            let options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            let observer = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.intersectionRatio > 0) {
                        entry.target.classList.toggle('animate');
                      }
                });
            }, options);

            let elements = document.querySelectorAll('.anim');
            console.log(elements)
            elements.forEach(element => {
                observer.observe(element);
            });
        });