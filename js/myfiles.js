window.addEventListener("load", async function (event) {
  //   <div class="file-card">
  //   <button class="btn btn-primary view-btn">View</button>
  // </div>

  let uploaded_files_display = document.getElementById("files-list");
  let filename = "";
  let coursecodes = [
    "1XC3",
    "1JC3",
    "1MD3",
    "1DM3",
    "1B03",
    "1XD3",
    "1ZB3",
    "1ZA3",
  ];
  let orderbyoption = "`download-number`";
  let macID = "";

  function displayResults(rows) {
    uploaded_files_display.innerHTML = "Doesn't Match Search Bar :/ ";
    if (rows.length === 0 || rows == null || rows == false) {
      console.log("No uploaded files");
    } else {
      uploaded_files_display.innerHTML = "";
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

        view_button.setAttribute("id", "view_button");
        view_button.innerHTML = "View";

        async function getFileDetails() {
          const response = await fetch("server/filedetails.php");
          const data = await response.json(); // Wait for JSON parsing
          console.log(data.message);

          let urlwithparams = `searchfiledetails.html?filename=${encodeURIComponent(
            data.message.path.slice(11)
          )}&filetitle=${encodeURIComponent(
            data.message.title
          )}&filedescription=${encodeURIComponent(
            data.message.description
          )}&coursecode=${encodeURIComponent(data.message.coursecode)}`;

          window.location.href = urlwithparams;
        }

        view_button.addEventListener("click", async function (event) {
          const formData = new FormData();
          formData.append("clicked", "true");
          formData.append("filetitle", row.filetitle);

          const response = await fetch("server/selectfiletoview.php", {
            method: "POST",
            body: formData,
          });

          getFileDetails();
        });
        // makes file user clicked on set to true

        file_card.appendChild(h3_file_title);
        file_card.appendChild(file_info);
        file_card.appendChild(view_button);

        uploaded_files_display.appendChild(file_card);
      }
    }
  }

  async function searchDatabase(to_send, url) {
    const response = await fetch(url, {
      method: "POST",
      body: to_send,
    });

    const data = await response.json(); // Wait for JSON parsing
    return data; // different fields for search.php
  }

  let user_files_plus_macid = (await searchDatabase("", "server/myfiles.php"))
    .message;
  macID = user_files_plus_macid[1];
  displayResults(user_files_plus_macid[0]);
  console.log(macID);

  async function submitForm(filename, coursecodes, orderbyoption) {
    formData = new FormData();
    formData.append("query", filename);
    formData.append("coursecodefilter", JSON.stringify(coursecodes));
    formData.append("orderbyoption", orderbyoption);
    formData.append("macID", macID);

    displayResults(
      (await searchDatabase(formData, "server/searchmyfiles.php")).message
    );
  }

  //search inputs

  document
    .getElementById("uploadedSearchInput")
    .addEventListener("input", function (event) {
      filename = this.value;
      submitForm(filename, { coursecodes: coursecodes }, orderbyoption);
    });

  for (let coursecodecheckbox of document.getElementsByClassName(
    "coursecodecheckboxes"
  )) {
    coursecodecheckbox.addEventListener("click", function (event) {
      if (this.checked) {
        coursecodes.push(this.value);
      } else {
        let copy = [];
        for (let c of coursecodes) {
          if (c != this.value) {
            copy.push(c);
          }
        }
        coursecodes = copy;
      }
      console.log(coursecodes);
      submitForm(filename, { coursecodes: coursecodes }, orderbyoption);
    });
  }

  document.getElementById("sortSelect").addEventListener("change", function () {
    selectedValue = this.value;

    if (selectedValue === "Highest Rated") {
      orderbyoption = "rating";
    } else if (selectedValue === "Most Downloaded") {
      orderbyoption = "`download-number`";
    } else if (selectedValue === "Newest") {
      orderbyoption = "upload_time";
    } else if (selectedValue === "Name") {
      orderbyoption = "filetitle";
    }
    submitForm(filename, { coursecodes: coursecodes }, orderbyoption);
  });
});
