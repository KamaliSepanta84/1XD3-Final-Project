//SETTINGS DROPDOWN JS
function myFunction() {
  //Get Dom Elements
  let dropbtn = document.querySelector('.dropbtn');
  let dropdown = document.getElementById("myDropdown");
  
  // If the dropdown is already open, close it and remove focus
  if (dropdown.classList.contains("show")) {
    dropdown.classList.remove("show");
    dropbtn.blur();
  } else {
    dropdown.classList.add("show");
  }
}
