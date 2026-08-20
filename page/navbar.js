fetch("navbar.html")
.then(response => response.text())
.then(data => {
    document.getElementById("navbar").innerHTML = data;

    let page = window.location.pathname.split("/").pop();

    document.querySelectorAll("nav a").forEach(link => {
        let linkPage = link.getAttribute("href");

        if (linkPage === page) {
            link.classList.add("active");
        }
    });
});