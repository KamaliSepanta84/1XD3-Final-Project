document.addEventListener("DOMContentLoaded", () => {
  // GRID/LIST VIEW CODE
  let gridViewBtn = document.getElementById("gridView");
  let listViewBtn = document.getElementById("listView");
  let resultsContainer = document.querySelector(".results-container");

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
  search_bar.addEventListener("input", function (event) {
    let formData = new FormData();
    formData.append("query", search_bar.value);

    fetch("server/search.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json()) // Parse the JSON response
      .then((data) => {
        console.log(data);
        for (let row of data) {
          // data is a list of objects and each objecrt is a row from the database
          let testDiv = document.createElement("div");
          testDiv.innerHTML = row;
          resultsContainer.appendChild(testDiv);
          // example of formatting to put on the div,
        }
      });
  });
});