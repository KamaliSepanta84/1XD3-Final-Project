//File details JS
document.addEventListener("DOMContentLoaded", () => {
    //ACCORDION CODE
    //Get DOM ELements
    const accordionBtn = document.getElementById("accordionBtn");
    const accordionContent = document.getElementById("accordionContent");
    
    // Toggle the display of the rating distribution accordion
    accordionBtn.addEventListener("click", () => {
      if (accordionContent.style.display === "block") {
        accordionContent.style.display = "none";
        //Changing icons
        accordionBtn.querySelector("i").classList.remove("ri-arrow-up-s-line");
        accordionBtn.querySelector("i").classList.add("ri-arrow-down-s-line");
      } else {
        accordionContent.style.display = "block";
        //Changing icons
        accordionBtn.querySelector("i").classList.remove("ri-arrow-down-s-line");
        accordionBtn.querySelector("i").classList.add("ri-arrow-up-s-line");
      }
    });
  });
  