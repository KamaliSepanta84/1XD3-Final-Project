window.addEventListener("load", function (event) {

  //   <div class="file-card" data-name="Lecture Notes - Calculus" data-rating="4.5" data-downloads="1234">
  //   <h3>Lecture Notes - Calculus</h3>
  //   <div class="file-info">
  //     <span class="rating"><i class="ri-star-fill"></i> 4.5</span>
  //     <span class="downloads"><i class="ri-download-2-line"></i> (1,234)</span>
  //   </div>
  //   <button class="btn btn-primary view-btn">View</button>
  // </div>

  let uploaded_files_display = document.getElementById("files-list");


  function displayResults(rows){
    if (rows.length === 0){
      uploaded_files_display.innerHTML = "Nothing to show";
      console.log("Nothing to show");
    }
    else{
      uploaded_files_display.innerHTML ="HEllo, you bless???";
      console.log("HEllo, you bless???");
    }
  }
  async function searchDatabase() {
    const response = await fetch("server/myfiles.php", {
      method: "POST",
      body: "",
    });

    const data = await response.json(); // Wait for JSON parsing

    displayResults(data.message);
  }


  searchDatabase();
});
