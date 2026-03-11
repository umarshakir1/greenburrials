document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.reviews-track');
    const slides = document.querySelectorAll('.review-card');
    const prevButton = document.querySelector('.slider-nav.prev');
    const nextButton = document.querySelector('.slider-nav.next');
    
    let currentIndex = 0;
    
    function updateSlidePosition() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
    
    function moveToNextSlide() {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            updateSlidePosition();
        }
    }
    
    function moveToPrevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlidePosition();
        }
    }
    
    prevButton.addEventListener('click', moveToPrevSlide);
    nextButton.addEventListener('click', moveToNextSlide);
    
    // Update button states
    function updateButtonStates() {
        prevButton.style.opacity = currentIndex === 0 ? '0.5' : '1';
        nextButton.style.opacity = currentIndex === slides.length - 1 ? '0.5' : '1';
    }
    
    // Initialize button states
    updateButtonStates();
    
    // Update button states after slide changes
    track.addEventListener('transitionend', updateButtonStates);
});
