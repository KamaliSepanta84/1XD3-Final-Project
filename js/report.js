window.addEventListener("load", function(event){
    const params = new URLSearchParams(window.location.search);
    const filename = params.get("filename");
    const filetitle = params.get("filetitle");
    const coursecode = params.get("coursecode");
    const macID = params.get("macID");

    const fileTitleBox = document.getElementById("filetitle");
    const courseCodeBox = document.getElementById("coursecode");
    const usernameBox = this.document.getElementById("username");

    let formData = new FormData();
    formData.append("filename", filename);

    fetch("server/getUserFromFileName.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            fileTitleBox.value = filetitle;
            courseCodeBox.value = coursecode;
            usernameBox.value = data.user_name;
        })
        .catch((error) => console.error("Error:", error));
});
