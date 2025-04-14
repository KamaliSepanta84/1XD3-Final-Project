window.addEventListener("load", function (event) {
  //   <div class="file-card">
  //   <button class="btn btn-primary view-btn">View</button>
  // </div>

  let uploaded_files_display = document.getElementById("files-list");

  function displayResults(rows) {
    uploaded_files_display.innerHTML = "";
    if (rows.length === 0) {
      uploaded_files_display.innerHTML = "No uploaded files";
      console.log("No uploaded files");
    } else {
      for (let row of rows) {
        let file_card = document.createElement("div");
        file_card.classList.add("file-card");

        let h3_file_title = document.createElement("h3");
        h3_file_title.innerHTML = row.filetitle;

        let file_info = document.createElement("div");
        file_info.classList.add("file-info");

        let rating_display = document.createElement("span");
        rating_display.classList.add("rating");
        rating_display.innerHTML = '<i class="ri-star-fill"></i> ' + row.rating;
        let download_display = document.createElement("span");
        download_display.classList.add("downloads");
        download_display.innerHTML =
          '<i class="ri-download-2-line"></i> ' + row["download-number"];
        file_info.appendChild(rating_display);
        file_info.appendChild(download_display);

        let view_button = document.createElement("a");
        view_button.classList.add("btn", "btn-primary", "view-btn");
        view_button.setAttribute("href", "filedetails.html");
        view_button.setAttribute("target", "");
        view_button.setAttribute("id", "view_button");
        view_button.innerHTML = "View";

        view_button.addEventListener("click", async function (event) {
          const formData = new FormData();
          formData.append("clicked", "true");
          formData.append("filetitle", row.filetitle);

          const response = await fetch("server/selectfiletoview.php", {
            method: "POST",
            body: formData,
          });

          const data = await response.json(); // Wait for JSON parsing

          console.log(data.message);
        });

        file_card.appendChild(h3_file_title);
        file_card.appendChild(file_info);
        file_card.appendChild(view_button);

        uploaded_files_display.appendChild(file_card);
      }
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
