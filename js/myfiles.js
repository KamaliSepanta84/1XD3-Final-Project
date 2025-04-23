window.addEventListener("load", async function (event) {

  let uploaded_files_display = document.getElementById("uploaded-files-list");
  let downloaded_files_display = document.getElementById(
    "downloaded-files-list"
  );

  let uploadedfiletitle = "";
  let downloadedfiletitle = "";
  let uploaded_coursecodes = [
    "1XC3",
    "1JC3",
    "1MD3",
    "1DM3",
    "1B03",
    "1XD3",
    "1ZB3",
    "1ZA3",
  ];
  let downloaded_coursecodes = [
    "1XC3",
    "1JC3",
    "1MD3",
    "1DM3",
    "1B03",
    "1XD3",
    "1ZB3",
    "1ZA3",
  ];
  let uploadedorderbyoption = "`download-number`";
  let downloadedorderbyoption = "`download-number`";

  // MAKING SEPERATE VARIABLES FOR UPLOAD AND DOWNLOAD

  let macID = "";

  function displayResults(rows, filecontainer) {
    filecontainer.innerHTML = "No Files Searched";
    if (rows.length === 0 || rows == null || rows == false) {
      console.log("No uploaded files");
    } else {
      filecontainer.innerHTML = "";
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
        view_button.setAttribute(
          "href",
          `searchfiledetails.html?filename=${encodeURIComponent(
            row.filename
          )}&filetitle=${encodeURIComponent(
            row.filetitle
          )}&filedescription=${encodeURIComponent(
            row.description
          )}&coursecode=${encodeURIComponent(row.coursecode)}`
        );
        view_button.innerHTML = "View";

        file_card.appendChild(h3_file_title);
        file_card.appendChild(file_info);
        file_card.appendChild(view_button);

        filecontainer.appendChild(file_card);
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

  async function submitForm(
    filetitle,
    coursecodes,
    orderbyoption,
    filecontainer,
    category
  ) {
    formData = new FormData();
    formData.append("filetitle", filetitle);
    formData.append("coursecodefilter", JSON.stringify(coursecodes));
    formData.append("orderbyoption", orderbyoption);
    formData.append("macID", macID);
    formData.append("category", category);

    let results = await searchDatabase(formData, "server/myfiles.php");
    if (results.error === "") {
      displayResults(results.message, filecontainer);
      console.log(results.message);
    } else {
      console.log(results.error);
    }
  }

  function searchEventListeners(
    searchBarID,
    filetitle,
    checkboxclass,
    sortSelectID,
    coursecodecategory,
    orderbyoption,
    filesdisplay,
    category
  ) {
    document
      .getElementById(searchBarID)
      .addEventListener("input", function (event) {
        filetitle = this.value;
        submitForm(
          filetitle,
          { coursecodes: coursecodecategory },
          orderbyoption,
          filesdisplay,
          category
        ); // might have to change field name
      });

    for (let coursecodecheckbox of document.getElementsByClassName(
      checkboxclass
    )) {
      coursecodecheckbox.addEventListener("click", function (event) {
        if (this.checked) {
          coursecodecategory.push(this.value);
        } else {
          let copy = [];
          for (let c of coursecodecategory) {
            if (c != this.value) {
              copy.push(c);
            }
          }
          coursecodecategory = copy;
        }
        console.log(this.value);
        submitForm(
          filetitle,
          { coursecodes: coursecodecategory },
          orderbyoption,
          filesdisplay,
          category
        ); // might have to change field name
      });
    }

    document
      .getElementById(sortSelectID)
      .addEventListener("change", function () {
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
        submitForm(
          filetitle,
          { coursecodes: coursecodecategory },
          orderbyoption,
          filesdisplay,
          category
        ); // might have to change field name
      });
  }

  let retreiveMacID = new FormData();
  retreiveMacID.append("category","macID");
  macID= (await searchDatabase(retreiveMacID, "server/myfiles.php")).message[0].macID;

  submitForm(uploadedfiletitle,{ coursecodes: uploaded_coursecodes },uploadedorderbyoption,uploaded_files_display,"uploads");
  submitForm(downloadedfiletitle,{ coursecodes: downloaded_coursecodes },downloadedorderbyoption,downloaded_files_display,"downloads");

  searchEventListeners(
    "uploadedSearchInput",
    uploadedfiletitle,
    "uploadedcoursecodecheckboxes",
    "uploadedSortSelect",
    uploaded_coursecodes,
    uploadedorderbyoption,
    uploaded_files_display,
    "uploads"
  );
  searchEventListeners(
    "downloadedSearchInput",
    downloadedfiletitle,
    "downloadedcoursecodecheckboxes",
    "downloadedSortSelect",
    downloaded_coursecodes,
    downloadedorderbyoption,
    downloaded_files_display,
    "downloads"
  );
});

