function toggleDropdown() {
    let dropdown = document.getElementById("dropdown-menu");
    let overlay = document.getElementById("overlay");

    if (dropdown.classList.contains("show")) {
        closeDropdown();
    } else {
        dropdown.classList.add("show");
        overlay.classList.add("show");
    }
}

function closeDropdown() {
    document.getElementById("dropdown-menu").classList.remove("show");
    document.getElementById("overlay").classList.remove("show");
}

document.querySelectorAll("button, .class-card").forEach(el => {
    el.addEventListener("click", function (e) {
        let ripple = document.createElement("span");
        ripple.classList.add("ripple");
        this.appendChild(ripple);

        let x = e.clientX - this.offsetLeft;
        let y = e.clientY - this.offsetTop;
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;

        setTimeout(() => ripple.remove(), 600);
    });
});
