window.addEventListener("load", function (event) {
  console.log("Hello");

  async function searchDatabase() {
    const response = await fetch("server/filedetails.php");

    const data = await response.json(); // Wait for JSON parsing

    console.log(data.message);
  }

  searchDatabase();
});
