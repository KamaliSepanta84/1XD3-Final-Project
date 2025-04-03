window.addEventListener("load", function(event) {
  const container = document.getElementById("container");
  const overlayBtnSignUp = document.getElementById("overlay-btn-signup");
  const overlayBtnSignIn = document.getElementById("overlay-btn-signin");
  const companyName = document.getElementById("title-container");
  const signUpResultContainer = document.getElementById("signup-result");

  overlayBtnSignUp.addEventListener("click", () => {
      container.classList.toggle("right-panel-active");
      companyName.classList.toggle("title-primary");
      companyName.classList.toggle("title-white");
  });

  overlayBtnSignIn.addEventListener("click", () => {
      container.classList.toggle("right-panel-active");
      companyName.classList.toggle("title-primary");
      companyName.classList.toggle("title-white");
  });

  let signUpEmailEntryBox = document.getElementById("signup-email");
  let signUpNameEntryBox = document.getElementById("signup-username");
  let signUpPasswordEntryBox = document.getElementById("signup-password");
  let signUpBtn = document.getElementById("signup-btn");

  signUpBtn.addEventListener("click", function(event) {
      event.preventDefault(); 

      let username = signUpNameEntryBox.value.trim();
      let userEmail = signUpEmailEntryBox.value.trim();
      let userPassword = signUpPasswordEntryBox.value.trim();

      if (username === "" || userEmail === "" || userPassword === "") {
          signUpResultContainer.textContent = "All fields are required!";
          signUpResultContainer.style.color = "red";
          return;
      }

      let params = "username=" + (username) + 
                   "&email=" + (userEmail) + 
                   "&password=" + (userPassword);

      let config = {
          method: 'POST',
          body: params 
      };

      console.log(params); // Debugging

      fetch("./server/login.php", config)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Debugging response
            signUpResultContainer.innerHTML = "<p>" + data.message + "</p>";
            signUpResultContainer.style.color = data.status === "Success" ? "green" : "red";
        });
    });

});

