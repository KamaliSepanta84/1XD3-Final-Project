window.addEventListener("load", function (event) {
  let filedisplay = document.getElementById("filedisplay");
  let filetitle = document.getElementById("filetitle");
  let filedescription = document.getElementById("filedescription");
  let coursecode = document.getElementById("coursecode");

  async function searchDatabase() {
    const response = await fetch("server/filedetails.php");
    const data = await response.json(); // Wait for JSON parsing
    console.log(data.message);

    filedisplay.src = "" + data.message.path.slice(3);

    filetitle.innerHTML = "Title: " + data.message.title;
    filedescription.innerHTML = "Description: " + data.message.description;
    coursecode.innerHTML = "Course Code: " + data.message.coursecode;
  }

  searchDatabase();
  console.log(sessionStorage.filename, "Hello");
});
