//HOME PAGE JS
document.addEventListener("DOMContentLoaded", () => {
    // CAROSEL CODE
    //Set DOM elements and variables
    let slides = document.querySelector('.slides');
    let slideElements = document.querySelectorAll('.slide');
    let totalSlides = slideElements.length;
    let currentIndex = 0;
    // Set the width of the slides container
    function updateCarousel() {
      slides.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
    }
    // Next button
    document.querySelector('.next').addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateCarousel();
    });
    // Prev button
    document.querySelector('.prev').addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateCarousel();
    });
    // Auto-play
    setInterval(() => {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateCarousel();
    }, 4000);
  });