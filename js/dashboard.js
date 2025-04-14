//Dashboard JS
window.addEventListener("load", function(event) {
  // CAROSEL CODE
  //Set DOM elements and variables
  let slidesContainer = document.querySelector('.multi-item-carousel .slides');
  let slideItems = document.querySelectorAll('.multi-item-carousel .slide');
  let totalSlides = slideItems.length; 
  let visibleSlides = 3;               
  let maxIndex = totalSlides - visibleSlides; 
  let currentIndex = 0;

  // Set the width of the slides container
  function updateCarousel() {
    // Move the container by the width of one slide (which is 100/3% each time)
    let offset = -currentIndex * (100 / visibleSlides);
    slidesContainer.style.transform = `translateX(${offset}%)`;
  }

  // Next button
  document.querySelector('.multi-item-carousel .next')
    .addEventListener('click', () => {
      currentIndex++;
      if (currentIndex > maxIndex) {
        currentIndex = 0;
      }
      updateCarousel();
    });

  // Prev button
  document.querySelector('.multi-item-carousel .prev')
    .addEventListener('click', () => {
      currentIndex--;
      if (currentIndex < 0) {
        currentIndex = maxIndex;
      }
      updateCarousel();
    });

  // Auto-play
  setInterval(() => {
    currentIndex = (currentIndex + 1) % (maxIndex + 1);
    updateCarousel();
  }, 4000);

  // DROPDOWN PANEL CODE
  // Set DOM Elements
  const toggleButtons = document.querySelectorAll(".dropdown-band .toggle-panel");
  // Set events for toggle buttons
  toggleButtons.forEach(button => {
    button.addEventListener("click", function (e) {
      e.stopPropagation(); // Prevent the click event from bubbling up
      let target = button.getAttribute("data-target");
      let panel = document.querySelector(`.dropdown-panel.${target}`);
      panel.classList.toggle("open");
    });
  });
  //Close both panels when clicked outside
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".dropdown-band") && !e.target.closest(".dropdown-panels")) {
      document.querySelectorAll(".dropdown-panel").forEach(panel => {
        panel.classList.remove("open");
      });
    }
  });

  let userWelcomeHeader = document.getElementById("user-welcome-header");
  fetch("./server/getUser.php")
    .then(response => response.json())
    .then((data) =>{
      if (data.access){
        let username = data.username;
        userWelcomeHeader.innerHTML = `Hello, ${username}`;
      }
    })

    let userTotalUploads = document.getElementById("user-total-uploads");
    let userTotalDownloads = document.getElementById("user-total-downloads");
    let userTotalRatings = document.getElementById("user-total-ratings");

    setInterval(function () {
      fetch("./server/dashboard.php")
        .then(response => response.json())
        .then(data => {
          userTotalUploads.innerHTML = data.numberOfUploads;
          userTotalDownloads.innerHTML = data.numberOfDownloads;
        })
        .catch(error => {
          console.error("Error fetching dashboard data:", error);
        });
    }, 100);
    
});