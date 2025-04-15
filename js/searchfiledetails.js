window.addEventListener("load", function (event) {
  const params = new URLSearchParams(window.location.search);
  const filename = params.get("filename");
  const filetitle = params.get("filetitle");
  const filedescription = params.get("filedescription");
  const coursecode = params.get("coursecode");

  document.getElementById("filedisplay").src = "uploads/" + filename;
  document.getElementById("filetitle").innerHTML = "Title: " + filetitle;
  document.getElementById("filedescription").innerHTML =
    "Description: " + filedescription;
  document.getElementById("coursecode").innerHTML =
    "Course Code: " + coursecode;
});
