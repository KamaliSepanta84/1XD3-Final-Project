window.addEventListener("load", function(event){
      const container = document.getElementById("container");
      const overlayBtnSignUp = document.getElementById("overlay-btn-signup");
      const overlayBtnSignIn = document.getElementById("overlay-btn-signin");
      const companyName = this.document.getElementById("title-container");

      overlayBtnSignUp.addEventListener("click", () => {
        container.classList.toggle("right-panel-active");
        companyName.classList.toggle("title-primary");
        companyName.classList.toggle("title-white");
        overlayBtn.classList.remove("scale-btn-animation");
        window.requestAnimationFrame(() => {
          overlayBtn.classList.add("scale-btn-animation");
        });
      });

      overlayBtnSignIn.addEventListener("click", () => {
        container.classList.toggle("right-panel-active");
        companyName.classList.toggle("title-primary");
        companyName.classList.toggle("title-white");
        overlayBtn.classList.remove("scale-btn-animation");
        window.requestAnimationFrame(() => {
          overlayBtn.classList.add("scale-btn-animation");
        });
      });
});