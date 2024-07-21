window.addEventListener('scroll', function() {
    // Get the section1 element
    const section1 = document.getElementById('section1');
    const carouselOverlay = document.querySelector('.carousel-overlay');

    // Get the bounding rectangle of section1
    const section1Rect = section1.getBoundingClientRect();

    // Check if the section1 is in the viewport
    if (section1Rect.top <= 0 && section1Rect.bottom >= 0) {
        // Make the carousel-overlay fixed
        carouselOverlay.style.position = 'fixed';
        carouselOverlay.style.bottom = '20px';
        carouselOverlay.style.left = '20px';
        carouselOverlay.style.right = '20px';
    } else {
        // Reset position if section1 is out of view
        carouselOverlay.style.position = 'absolute';
        carouselOverlay.style.bottom = '20px';
        carouselOverlay.style.left = '20px';
        carouselOverlay.style.right = '20px';
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });
});

