window.addEventListener("load", function(event){

    let fileTitleInput = document.getElementById("titleInput");
    let courseCodeInput = document.getElementById("courseInput");
    let descriptionInput = document.getElementById("descriptionInput");

    document.getElementById("uploadButton").addEventListener("click", function (event) {
        event.preventDefault(); 
        
        let fileInput = document.getElementById("file");
        let file = fileInput.files[0];

        let filetitle = fileTitleInput.value.trim();
        let coursecode = courseCodeInput.value.trim();
        let description = descriptionInput.value.trim();
        
        if (!file) {
            showMessage("Please select a file to upload.", "error");
            return;
        }

        let formData = new FormData();
        formData.append("file", file);
        formData.append("filetitle", filetitle);
        formData.append("coursecode", coursecode);
        formData.append("description", description);

        fetch("./server/upload.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, "success");
                fileInput.value = "";
                fileTitleInput.value = "";
                courseCodeInput.value = "";
                descriptionInput.value = "";
            } else {
                showMessage(data.message, "error");
            }
        })
        .catch(error => {
            showMessage("Something went wrong. Try again!", "error");
        });
    });

    function showMessage(message, type) {
        let messageBox = document.getElementById("uploadMessage");
        messageBox.textContent = message;
        messageBox.style.color = type === "success" ? "green" : "red";
        messageBox.style.display = "block";
    }

    fileTitleInput.addEventListener("input", function(event){
        let currentValue = this.value;

        if (currentValue.length > 199) {
            this.value = currentValue.slice(0, 199);
        }

        if (currentValue.length === 199) {
            this.maxLength = 199; 
        }
    });
    
    courseCodeInput.addEventListener("input", function (event) {
        let currentValue = this.value;

        if (currentValue.length > 5) {
            this.value = currentValue.slice(0, 5);
        }

        if (currentValue.length === 5) {
            this.maxLength = 5; 
        }
    });
    
    descriptionInput.addEventListener("input", function (event) {
        let currentValue = this.value;

        if (currentValue.length > 199) {
            this.value = currentValue.slice(0, 199);
        }

        if (currentValue.length === 199) {
            this.maxLength = 199; 
        }
    });

});
