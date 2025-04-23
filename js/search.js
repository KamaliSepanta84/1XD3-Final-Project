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


  // let main = document.getElementById("main");

  // document.querySelector(".sidebar").addEventListener("click",function(event){
  //   console.log("hello");
  //   this.style.width = "5%";
  //   main.style.width = "95%"
  // })




  // SEARCH FUNCTIONALITY
  let search_bar = document.getElementById("search_bar");
  let results = [];
  let formData;
  let min_size_slider = document.getElementById("min_size_slider");
  let max_size_slider = document.getElementById("max_size_slider");
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
        ratingNumber.innerHTML = row.rating;
        ratingSpan.appendChild(ratingNumber);

        let downloadSpan = document.createElement("span");
        downloadSpan.classList.add("downloads");
        let downloadSymbol = document.createElement("i");
        starSymbol.classList.add("ri-download-2-line");
        downloadSpan.appendChild(downloadSymbol);
        let downloadNumber = document.createElement("span");
        downloadNumber.setAttribute("id", "downloadNumber");
        downloadNumber.innerHTML = row["download-number"];
        downloadSpan.appendChild(downloadNumber);

        resultInfoDiv.appendChild(ratingSpan);
        resultInfoDiv.appendChild(downloadSpan);

        // adding all above elements to container div
        containerDiv.appendChild(courseTitleAndNoteName);
        containerDiv.appendChild(courseDescription);
        containerDiv.appendChild(resultInfoDiv);

        // Create download button
        let downloadButton = document.createElement("a");
        downloadButton.href = "uploads/" + encodeURIComponent(row.filename); // Now correctly points to 'uploads/'
        downloadButton.classList.add("download-btn");
        downloadButton.textContent = "Download";
        downloadButton.setAttribute("download", row.filename); // triggers browser download
        containerDiv.appendChild(downloadButton);

        let viewbutton = document.createElement("a");
        viewbutton.innerHTML = "Preview";
        viewbutton.classList.add("download-btn");
        viewbutton.setAttribute(
          "href",
          `searchfiledetails.html?filename=${encodeURIComponent(
            row.filename
          )}&filetitle=${encodeURIComponent(
            row.filetitle
          )}&filedescription=${encodeURIComponent(
            row.description
          )}&coursecode=${encodeURIComponent(row.coursecode)}`
        );

        viewbutton.setAttribute("target", "");
        containerDiv.appendChild(viewbutton);

        downloadButton.addEventListener("click", function (event) {
          event.preventDefault(); // it stops the browser's default behavior

          const filename = this.getAttribute("download");

          let formData = new FormData();
          formData.append("filename", filename);
          console.log(filename); // just for debugging
          fetch("server/download.php", {
            method: "POST",
            body: formData,
          })
            .then(() => {
              // Now trigger the actual download
              const a = document.createElement("a");
              a.href = "uploads/" + encodeURIComponent(filename);
              a.setAttribute("download", filename);
              a.style.display = "none";
              document.body.appendChild(a);
              a.click();
              document.body.removeChild(a);
            })
            .catch((error) => console.error("Error:", error));
        });

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
      console.log(data.result);
    } else {
      console.log(data.error);
    }
  }

  function submitForm(filename, filesizerange, coursecodes, orderbyoption) {
    formData = new FormData();
    formData.append("query", filename);
    formData.append("filesizefilter", JSON.stringify(filesizerange)); //formData object does not support objects, so i make it into string
    formData.append("coursecodefilter", JSON.stringify(coursecodes));
    formData.append("orderbyoption", orderbyoption);
    searchDatabase();
  }

  function getNotes() {
    if (Number(max_size_slider.value) > Number(min_size_slider.value)) {
      submitForm(
        search_bar.value,
        { max: max_size_slider.value, min: min_size_slider.value },
        { coursecodes: coursecodes },
        orderbyoption
      );
    } else {
      resultsContainer.innerHTML =
        "Max file size is smaller than Min file size!!";
      console.log("Max: ", max_size_slider.value);
      console.log("Min: ", min_size_slider.value);
    }
  }

  search_bar.addEventListener("input", function (event) {
    getNotes();
  });

  min_size_slider.addEventListener("input", function (event) {
    if (parseInt(min_size_slider.value) > parseInt(max_size_slider.value)) {
      min_size_slider.value = max_size_slider.value;
    }
    getNotes();
  });

  max_size_slider.addEventListener("input", function (event) {
    if (parseInt(max_size_slider.value) < parseInt(min_size_slider.value)) {
      max_size_slider.value = min_size_slider.value;
    }
    getNotes();
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
      getNotes();
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
    getNotes();
  });
});
