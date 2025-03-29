//UPLOAD PAGE JS
document.addEventListener("DOMContentLoaded", () => {
    //DRAG DROP CODE
    // Set DOM elements
    let dragDropArea = document.getElementById("dragDropArea");
    let fileInput = document.getElementById("fileInput");
    let progressBar = document.getElementById("progressBar");
    let uploadProgress = document.getElementById("uploadProgress");
    //Set events for drag and drop
    let events = ["dragenter", "dragover", "dragleave", "drop"];
    // Prevent default behavior
    events.forEach(function(eventname) {
        dragDropArea.addEventListener(eventname, defaultprev, false);
        document.body.addEventListener(eventname, defaultprev, false);
    });
    //Prevent default behavior function
    function defaultprev(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    //Highlighting the drop area (changing the background color)
    ["dragenter", "dragover"].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => {
          dragDropArea.classList.add("drag-over");
        }, false);
      });
    //Remove the highlight from the drop area
    ["dragleave", "drop"].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => {
          dragDropArea.classList.remove("drag-over");
        }, false);
      });
    //Handle drop event
    dragDropArea.addEventListener("drop", drophandle, false);
    //Handle drop event function
    function drophandle(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
    }  
    //click event 
    dragDropArea.addEventListener("click", () => {
        fileInput.click();
    });
    //when file is selected by browsing
    fileInput.addEventListener("change", () => {
        const files = fileInput.files;
        handleFiles(files);
    });
    //handling files function
    //THIS IS WHAT YOU SHOULD CHANGE AND ADD UPLOAD CODE. I HAVE USED CHAT BELOW FOR A SIMULATOR CODE
    function handleFiles(files) {
        if (!files || files.length === 0) return;
        console.log("Files selected:", files);
        // TODO: Here you would integrate your actual file upload logic.
        simulateUpload(); // For now, we simulate the upload progress.
      }
      function simulateUpload() {
        uploadProgress.style.display = "block";
        let progress = 0;
        let interval = setInterval(() => {
          progress += 10;
          progressBar.style.width = progress + "%";
          if (progress >= 100) {
            clearInterval(interval);
            console.log("Upload complete!");
          }
        }, 300);
    }
  //FORM HANDLING CODE FOR FORM   
  // Form Input Elements
  let titleInput = document.getElementById("titleInput");
  let descriptionInput = document.getElementById("descriptionInput");
  let tagsInput = document.getElementById("tagsInput");
  let courseInput = document.getElementById("courseInput");
  let subjectInput = document.getElementById("subjectInput");
  
  // Feedback elements
  let titleFeedback = document.getElementById("titleFeedback");
  let descFeedback = document.getElementById("descFeedback");
  let tagsFeedback = document.getElementById("tagsFeedback");
  let courseFeedback = document.getElementById("courseFeedback");
  let subjectFeedback = document.getElementById("subjectFeedback");
  
  // Submit button
  let submitButton = document.querySelector('.metadata-form button[type="submit"]');
  
  // Define word limit for description
  let wordLimit = 50;
  
  // Live feedback for Title (required)
  titleInput.addEventListener("input", () => {
      if (titleInput.value.trim() === "") {
          titleFeedback.textContent = "Title is required.";
          titleFeedback.style.color = "red";
      } else {
          titleFeedback.textContent = "";
      }
      checkFormValidity();
  });
  
  // Live feedback for Description (word counter)
  descriptionInput.addEventListener("input", () => {
    // Split the description into words, filter out empty words, and count the number of words
      let words = descriptionInput.value.trim().split(/\s+/).filter(word => word.length > 0);
      //Set variable for total word count
      let count = words.length;
      //Check if word count exceeds limit
      if (count > wordLimit) {
        //Set variable for excess word count
        let excess = count - wordLimit;
        // if excess is more than 1, display plural word (words), otherwise display singular word (word)
        if (excess > 1) {
          descFeedback.textContent = "You have exceeded the word limit by " + excess + " words.";
        } else {
          descFeedback.textContent = "You have exceeded the word limit by " + excess + " word.";
        }
        //Set feedback color to red
        descFeedback.style.color = "red";
      } else {
        //Set variable for remaining word count
        let remaining = wordLimit - count;
        // if remaining is 1, display singular word (word), otherwise display plural word (words)
        if (remaining === 1) {
          descFeedback.textContent = remaining + " word remaining.";
        } else {
          descFeedback.textContent = remaining + " words remaining.";
        }
        //Set feedback color to green
        descFeedback.style.color = "green";
      }
      checkFormValidity();
  });
  
  // Live feedback for Tags (at least 3 tags required)
  tagsInput.addEventListener("input", () => {
      // Split the tags by commas, trim each tag, filter out empty tags, and count the number of tags
      let tagArray = tagsInput.value.split(",").map(tag => tag.trim()).filter(tag => tag.length > 0);
      // Display feedback if less than 3 tags are entered
      if (tagArray.length < 3) {
          tagsFeedback.textContent = "Please enter at least 3 tags separated by commas.";
          tagsFeedback.style.color = "red";
      } else {
          tagsFeedback.textContent = "";
      }
      checkFormValidity();
  });

  //Live feedback for Subject
  subjectInput.addEventListener("input", () => {
      if (subjectInput.value.trim() === "") {
          subjectFeedback.textContent = "Subject is required.";
          subjectFeedback.style.color = "red";
      } else {
          subjectFeedback.textContent = "";
      }
      checkFormValidity();
  });

  
  // Live feedback for Course Code (required and must contain letter and number)
  courseInput.addEventListener("input", () => {
    // Regular expression pattern for course code (must contain at least one letter and one number)
    let coursePattern = /^(?=.*[A-Za-z])(?=.*\d).+$/;
      // Display feedback if course code is empty or does not match the pattern
      if (courseInput.value.trim() === "") {
          courseFeedback.textContent = "Course code is required.";
          courseFeedback.style.color = "red";
      // Display feedback if course code does not contain at least one letter and one number
      } else if (!coursePattern.test(courseInput.value.trim())) {
          courseFeedback.textContent = "Course code must contain at least one letter and one number.";
          courseFeedback.style.color = "red";
      // Clear feedback if course code is valid
      } else {
          courseFeedback.textContent = "";
      }
      checkFormValidity();
  });
  
  // Function to check overall form validity and update submit button
  function checkFormValidity() {
      let valid = true;
      
      // Check title
      if (titleInput.value.trim() === "") valid = false;
      
      // Check course code
      let coursePattern = /^(?=.*[A-Za-z])(?=.*\d).+$/;
      if (courseInput.value.trim() === "" || !coursePattern.test(courseInput.value.trim())) valid = false;
      
      // Check description word limit
      let words = descriptionInput.value.trim().split(/\s+/).filter(word => word.length > 0);
      if (words.length > wordLimit) valid = false;
      
      // Check tags (at least 3)
      let tagArray = tagsInput.value.split(",").map(tag => tag.trim()).filter(tag => tag.length > 0);
      if (tagArray.length < 3) valid = false;
      
      // Disable submit button if form is not valid
      submitButton.disabled = !valid;
      
      // Changing submit button color based on validity
      if (valid) {
          submitButton.style.backgroundColor = "var(--primary-color)";
      } else {
          submitButton.style.backgroundColor = "#ccc";
      }
  }
  // Check validity on page load
  checkFormValidity(); 
});