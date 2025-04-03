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
  let formData = new FormData();

  document
    .getElementById("size_filter")
    .addEventListener("click", function (event) {
      formData.append("query", search_bar.value);
      formData.append("filter", "size");
      fetch("server/search.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json()) // Parse the JSON response
        // DATA IS OF THE FORM [ERROR: ERROR_MESSAGE, RESULT: ROWS]
        .then((data) => {
          if (data["error"] === "") {
            displayResults(data.result);
          } else {
            console.log(data["error"]);
          }
        });
      console.log("size clicked");
    });

  search_bar.addEventListener("input", function (event) {
    formData.append("query", search_bar.value);
    console.log(formData);

    fetch("server/search.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json()) // Parse the JSON response
      // DATA IS OF THE FORM [ERROR: ERROR_MESSAGE, RESULT: ROWS]
      .then((data) => {
        if (data["error"] === "") {
          displayResults(data.result);
        } else {
          console.log(data["error"]);
        }
      });
  });

  function displayResults(rows) {
    results = rows;

    resultsContainer.innerHTML = "";
    console.log("results: ", results);
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
        console.log(row);
        // example of formatting to put on the div,
      }
    }
  }
});
