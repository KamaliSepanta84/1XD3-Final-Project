window.addEventListener("load", function(event){
  const container = document.getElementById("container");
  const overlayBtn = document.getElementById("overlayBtn");
  const companyName = this.document.getElementById("title-container");

  overlayBtn.addEventListener("click", () => {
    container.classList.toggle("right-panel-active");
    companyName.classList.toggle("title-primary");
    companyName.classList.toggle("title-white");
    overlayBtn.classList.remove("scale-btn-animation");
    window.requestAnimationFrame(() => {
      overlayBtn.classList.add("scale-btn-animation");
    });
  });
});