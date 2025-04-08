document.addEventListener("DOMContentLoaded", () => {
  // GRID/LIST VIEW CODE
  let gridViewBtn = document.getElementById("gridView");
  let listViewBtn = document.getElementById("listView");
  let resultsContainer = document.querySelector(".results-container");
  resultsContainer.innerHTML = "Notes Will Be Displayed Here";

  // Set classes for grid view
  gridViewBtn.addEventListener("click", () => {
    resultsContainer.classList.add("grid-view");
    resultsContainer.classList.remove("list-view");
    gridViewBtn.classList.add("active");
    listViewBtn.classList.remove("active");
  });

  // Set classes for list view
  listViewBtn.addEventListener("click", () => {
    resultsContainer.classList.add("list-view");
    resultsContainer.classList.remove("grid-view");
    listViewBtn.classList.add("active");
    gridViewBtn.classList.remove("active");
  });

  // SEARCH FUNCTIONALITY
  let search_bar = document.getElementById("search_bar");
  let results = [];
  let formData;
  let min_size_slider = document.getElementById("min_size_slider");
  let max_size_slider = document.getElementById("max_size_slider");
  let coursecodes = [];
  let applyfilters = document.getElementById("applyfilters");

  function displayResults(rows) {
    results = rows;

    resultsContainer.innerHTML = "";
    if (results.length === 0) {
      console.log("Nothing to show");
      resultsContainer.innerHTML = "No Results";
    } else {
      for (let row of results) {
        // results is a list of objects and each objecrt is a row from the database

        let containerDiv = document.createElement("div"); // create container div

        containerDiv.classList.add("result-card");
        let courseTitleAndNoteName = document.createElement("h3");
        courseTitleAndNoteName.innerHTML =
          row.coursecode + ": " + row.filetitle;
        let courseDescription = document.createElement("p");
        courseDescription.innerHTML = row.description;

        let resultInfoDiv = document.createElement("div");
        resultInfoDiv.classList.add("result-info");

        let ratingSpan = document.createElement("span");
        ratingSpan.classList.add("rating");
        let starSymbol = document.createElement("i");
        starSymbol.classList.add("ri-star-fill");
        ratingSpan.appendChild(starSymbol);
        let ratingNumber = document.createElement("span");
        ratingNumber.setAttribute("id", "ratingNumber");
        ratingNumber.innerHTML = "ADD RATE FIELD TO NOTES TABLE";
        ratingSpan.appendChild(ratingNumber);

        let downloadSpan = document.createElement("span");
        downloadSpan.classList.add("downloads");
        let downloadSymbol = document.createElement("i");
        starSymbol.classList.add("ri-download-2-line");
        downloadSpan.appendChild(downloadSymbol);
        let downloadNumber = document.createElement("span");
        downloadNumber.setAttribute("id", "downloadNumber");
        downloadNumber.innerHTML = "ADD DOWNLOAD NUM FIELD TO NOTES TABLE";
        downloadSpan.appendChild(downloadNumber);

        resultInfoDiv.appendChild(ratingSpan);
        resultInfoDiv.appendChild(downloadSpan);

        // adding all above elements to container div
        containerDiv.appendChild(courseTitleAndNoteName);
        containerDiv.appendChild(courseDescription);
        containerDiv.appendChild(resultInfoDiv);

        // adding container div to result container
        resultsContainer.appendChild(containerDiv);
      }
    }
  }

  async function searchDatabase() {
    const response = await fetch("server/search.php", {
      method: "POST",
      body: formData,
    });

    const data = await response.json(); // Wait for JSON parsing

    // DATA IS OF THE FORM [ERROR: ERROR_MESSAGE, RESULT: ROWS]
    if (data.error === "") {
      displayResults(data.result);
    } else {
      console.log(data.error);
    }
  }

  function submitForm(filename, filesizerange, coursecodes) {
    formData = new FormData();
    formData.append("query", filename);
    formData.append("filesizefilter", JSON.stringify(filesizerange)); //formData object does not support objects, so i make it into string
    formData.append("coursecodefilter", JSON.stringify(coursecodes));
    searchDatabase();
  }

  applyfilters.addEventListener("click", function (event) {
    if (max_size_slider.value > min_size_slider.value) {
      submitForm(
        search_bar.value,
        { max: max_size_slider.value, min: min_size_slider.value },
        {coursecodes: coursecodes}
      );
    }
  });

  search_bar.addEventListener("input", function (event) {
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
    });
  }
});
