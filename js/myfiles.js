//MY FILES PAGE JS
document.addEventListener("DOMContentLoaded", () => {
    //FILE UPLOAD SEARCH + SORT CODE
    //Get all DOM elements
    let uploadedSearchInput = document.getElementById("uploadedSearchInput");
    let sortSelect = document.getElementById("sortSelect");
    let uploadedFiles = document.getElementById("uploadedFiles");
    let noResultsMessageUploaded = document.getElementById("noResultsMessageUploaded");
    
    // Get all uploaded file cards as an array using Array.from
    let uploadedFileCards = Array.from(uploadedFiles.querySelectorAll(".file-card"));
    //filter uploaded files function
    function filterUploadedFiles() {
      // Get the search input value and convert it to uppercase (for easier comparison)
      let filter = uploadedSearchInput.value.toUpperCase();
      // Set found to false initially (for no results message)
      let found = false;
      // Loop through each card and check if the file name includes the search input
      uploadedFileCards.forEach(card => {
        // Get the file name and convert it to uppercase
        let fileName = card.getAttribute("data-name").toUpperCase();
        // If the file name includes the search input, display the card, otherwise hide it
        if (fileName.includes(filter)) {
          card.style.display = "";
          found = true;
        } else {
          card.style.display = "none";
        }
      });
      // If no cards were found, display the no results message, otherwise hide it
      if (found) {
        noResultsMessageUploaded.classList.remove("visible");
      } else {
        noResultsMessageUploaded.classList.add("visible");
      }    
    }
    //sort uploaded files function
    function sortUploadedFiles() {
        // Get the selected criteria from the sort select element (Ratings, Downloads, Name)
        let criteria = sortSelect.value;
        // get all uploaded file cards and sort them based on the selected criteria
        let sortedCards = Array.from(uploadedFileCards).sort((a, b) => {
        // Get the value of the selected criteria for each card
        let aValue, bValue;
        // For sorting by name, convert the names to lowercase and use localeCompare
        if (criteria === "name") {
          aValue = a.getAttribute("data-name").toLowerCase();
          bValue = b.getAttribute("data-name").toLowerCase();
          return aValue.localeCompare(bValue);
        // For sorting by rating, convert the ratings to float and compare them
        } else if (criteria === "rating") {
          aValue = parseFloat(a.getAttribute("data-rating"));
          bValue = parseFloat(b.getAttribute("data-rating"));
          return bValue - aValue;
        // For sorting by downloads, convert the downloads to integer and compare
        } else if (criteria === "downloads") {
          aValue = parseInt(a.getAttribute("data-downloads"), 10);
          bValue = parseInt(b.getAttribute("data-downloads"), 10);
          return bValue - aValue;
        }
      });
      // Append the sorted cards to the uploaded files container
      sortedCards.forEach(card => {
        uploadedFiles.appendChild(card);
      });
    }
    // Event listeners for search input and sort select
    uploadedSearchInput.addEventListener("keyup", () => {
      sortUploadedFiles();
      filterUploadedFiles();
    });
    sortSelect.addEventListener("change", () => {
      sortUploadedFiles();
      filterUploadedFiles();
    });
    
    // Initial sort and filter for uploaded files
    sortUploadedFiles();
    filterUploadedFiles();
    
    //FILE DOWNLOAD SEARCH CODE
    // Get all DOM elements
    let downloadedSearchInput = document.getElementById("downloadedSearchInput");
    let downloadedFiles = document.getElementById("downloadedFiles");
    let noResultsMessageDownloaded = document.getElementById("noResultsMessageDownloaded");
    
    // Get all downloaded file cards as an array
    let downloadedFileCards = Array.from(downloadedFiles.querySelectorAll(".file-card"));
    // Filter downloaded files function
    function filterDownloadedFiles() {
      let filter = downloadedSearchInput.value.toUpperCase();
      let found = false;
      downloadedFileCards.forEach(card => {
        let fileName = card.getAttribute("data-name").toUpperCase();
        if (fileName.includes(filter)) {
          card.style.display = "";
          found = true;
        } else {
          card.style.display = "none";
        }
      });
      // If no cards were found, display the no results message, otherwise hide it
      if (found) {
        noResultsMessageDownloaded.classList.remove("visible");
      } else {
        noResultsMessageDownloaded.classList.add("visible");
      }    
    }
    // Event listener for search input
    downloadedSearchInput.addEventListener("keyup", filterDownloadedFiles);

    //"VIEW FILE" BUTTON CODE
    let viewButtons = document.querySelectorAll(".view-btn");
    viewButtons.forEach(button => {
      button.addEventListener("click", () => {
        window.location.href = "filedetails.html";
      });
    });
  });
  