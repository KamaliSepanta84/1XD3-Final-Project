window.addEventListener("load", function (event) {
  const params = new URLSearchParams(window.location.search);
  const filename = params.get("filename");
  const filetitle = params.get("filetitle");
  const filedescription = params.get("filedescription");
  const coursecode = params.get("coursecode");

  document.getElementById("filedisplay").src = "uploads/" + filename;
  document.getElementById("filetitle").innerHTML = "Title: " + filetitle;
  document.getElementById("filedescription").innerHTML =
    "Description: " + filedescription;
  document.getElementById("coursecode").innerHTML =
    "Course Code: " + coursecode;
});


// FAILED ATTEMPT AT GETTING PDF ON CANVAS ELEMENT FOR NICEFR LOOKING PREVIEW FUNCTOINALITY


/*
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>test</title>
    <style>
      body {
        background-color: blue;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      canvas {
      }
    </style>
  </head>
  <body>
    <div id="pdf-container">
      <h1>Hello</h1>
      <canvas id = "the-canvas"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@5.1.91/wasm/openjpeg_nowasm_fallback.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pdfjs-dist@5.1.91/web/pdf_viewer.min.css">


    <script>
      //https://cdnjs.com/libraries/pdf.jsge
      //https://mozilla.github.io/pdf.js/examples/
      let loadingTask = pdfjsLib.getDocument("uploads/A4.pdf");
      loadingTask.promise.then(function (pdf) {
        // you can now use *pdf* here
        pdf.getPage(1).then(function (page) {
          // you can now use *page* here
          let scale = 1.5;
          let viewport = page.getViewport({ scale: scale });
          // Support HiDPI-screens.
          let outputScale = window.devicePixelRatio || 1;

          let canvas = document.getElementById("the-canvas");
          let context = canvas.getContext("2d");

          canvas.width = Math.floor(viewport.width * outputScale);
          canvas.height = Math.floor(viewport.height * outputScale);
          canvas.style.width = Math.floor(viewport.width) + "px";
          canvas.style.height = Math.floor(viewport.height) + "px";
          canvas.style.border = "2px solid black";

          let transform =
            outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

          let renderContext = {
            canvasContext: context,
            transform: transform,
            viewport: viewport,
          };
          page.render(renderContext);
        });
      });

    </script>
  </body>
</html>

 */
