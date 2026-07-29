fetch("navbar.html")
.then(r => r.text())
.then(t => {
    document.getElementById("navbar").innerHTML = t;

    let page = location.pathname.split("/").pop();

    document.querySelectorAll("nav a").forEach(link => {
        if (link.getAttribute("href") === page) {
            link.classList.add("active");
        }
    });
});