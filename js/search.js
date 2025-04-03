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
  let search_button = document.getElementsByClassName(
    "btn btn-primary search-btn"
  ); // only way is to return an array of one element
  let results = [];

  search_bar.addEventListener("input", function (event) {
    let formData = new FormData();
    formData.append("query", search_bar.value);

    fetch("server/search.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json()) // Parse the JSON response
      // DATA IS OF THE FORM [ERROR: ERROR_MESSAGE, RESULT: ROWS]
      .then((data) => {
        if (data["error"] === "") {
          results = data["result"];
        } else {
          console.log(data["error"]);
        }
      });
  });

  /**
   * Displays all relevant result cards
   */
  search_button[0].addEventListener("click", function (event) {
    resultsContainer.innerHTML = "";
    console.log("results: ", results);
    if (results.length === 0) {
      console.log("Nothing to show");
      resultsContainer.innerHTML =
        "No Results";
    } else {
      /**
HTML for result card

 <div class="result-card">
          <h3>Course Title / Note Name</h3>
          <p>
            Brief description about the note or resource. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
<div class="result-info">

            <span class="rating">
              <i class="ri-star-fill"></i> <span id = "ratingNumber" >4.5</span>
            </span>

            <span class="downloads">
              <i class="ri-download-2-line"></i> <span id = "downloadNumber" >(1,234)</span>
            </span>
          </div>
          <button class="btn btn-primary">Download</button>
  </div>
       */
      for (let row of results) {
        // results is a list of objects and each objecrt is a row from the database

        let containerDiv = document.createElement("div"); // create container div

        containerDiv.classList.add("result-card");
        let courseTitleAndNoteName = document.createElement("h3");
        courseTitleAndNoteName.innerHTML = row.coursecode + ": " + row.filename;
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
        console.log(row);
        // example of formatting to put on the div,
      }
    }
  });
});
