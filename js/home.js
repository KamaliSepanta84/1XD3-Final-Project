document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.carousel-item');
    const prevButton = document.querySelector('.carousel-controls .prev');
    const nextButton = document.querySelector('.carousel-controls .next');
    
    let currentIndex = 0;
    const totalItems = items.length;
    const intervalTime = 5000; // Auto-rotate every 5 seconds
    
    function showItem(index) {
      items.forEach((item, i) => {
        if (i === index) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      });
    }
    
    prevButton.addEventListener('click', function() {
      currentIndex = (currentIndex - 1 + totalItems) % totalItems;
      showItem(currentIndex);
    });
    
    nextButton.addEventListener('click', function() {
      currentIndex = (currentIndex + 1) % totalItems;
      showItem(currentIndex);
    });
    
    // Auto-rotate the carousel
    setInterval(function() {
      currentIndex = (currentIndex + 1) % totalItems;
      showItem(currentIndex);
    }, intervalTime);
  });
  