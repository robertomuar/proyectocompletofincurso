document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');

    let counter = 0;
    let slideWidth = slides[0].offsetWidth; 

    function nextSlide() {
        if (counter < slides.length - 1) {
            counter++;
        } else {
            counter = 0;
        }
        updateSlider();
    }

    function prevSlide() {
        if (counter > 0) {
            counter--;
        } else {
            counter = slides.length - 1;
        }
        updateSlider();
    }

    function updateSlider() {
            const offset = -counter * slideWidth;
            slider.style.transform = `translateX(${offset}px)`;

            const currentSlideText = slides[counter].querySelector('.slide-text');
            currentSlideText.style.display = 'block';
        }

    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);

    setInterval(nextSlide, 5000);

    window.addEventListener('resize', function () {
            slideWidth = slides[0].offsetWidth;

            slides.forEach(function (slide) {
                const image = slide.querySelector('img');
                image.style.width = slideWidth + 'px';
                image.style.height = 'auto'; 
            });
    });

    window.dispatchEvent(new Event('resize'));
});
function openLoginOverlay() {
    var overlay = document.getElementById("loginOverlay");
    overlay.style.display = "block"; 
}

function closeLoginOverlay() {
    var overlay = document.getElementById("loginOverlay");
    overlay.style.display = "none"; 
}

