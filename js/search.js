//SEARCH PAGE JS
document.addEventListener("DOMContentLoaded", () => {
    //GRID/LIST VIEW CODE
    // Set DOM elements
    let gridViewBtn = document.getElementById('gridView');
    let listViewBtn = document.getElementById('listView');
    let resultsContainer = document.querySelector('.results-container');
    // Set classes for grid view
    gridViewBtn.addEventListener('click', () => {
    resultsContainer.classList.add('grid-view');
    resultsContainer.classList.remove('list-view');
    gridViewBtn.classList.add('active');
    listViewBtn.classList.remove('active');
    });
    // Set classes for list view
    listViewBtn.addEventListener('click', () => {
    resultsContainer.classList.add('list-view');
    resultsContainer.classList.remove('grid-view');
    listViewBtn.classList.add('active');
    gridViewBtn.classList.remove('active');
    });

});