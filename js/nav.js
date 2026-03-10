// --- 1. Menu-items: oude omhoog, nieuwe omlaag ---
document.querySelectorAll("nav a").forEach(link => {
    link.addEventListener("click", function (e) {

        // Logo wordt apart afgehandeld
        if (this.classList.contains("logo-link")) return;

        e.preventDefault();
        const url = this.href;

        const currentActive = document.querySelector("nav a.active");
        const newActive = this;

        // Oude wolk omhoog
        if (currentActive) {
            currentActive.classList.remove("active");
        }

        // Nieuwe wolk omlaag
        newActive.classList.add("active");

        // Na 0.6 sec naar nieuwe pagina
        setTimeout(() => {
            window.location.href = url;
        }, 600);
    });
});


// --- 2. Logo: alleen actieve wolk rustig omhoog ---
const logo = document.querySelector(".logo-link");
if (logo) {
    logo.addEventListener("click", function (e) {
        e.preventDefault();
        const url = this.href;

        const currentActive = document.querySelector("nav a.active");

        if (currentActive) {
            // Transition weer aanzetten (was op "none" gezet op vorige pagina)
            currentActive.style.transition = "transform 0.5s ease";

            // Actieve wolk omhoog
            currentActive.classList.remove("active");
        }

        // Na 0.6 sec naar index.html
        setTimeout(() => {
            window.location.href = url;
        }, 600);
    });
}


// --- 3. Nieuwe pagina: active moet direct op juiste plek staan ---
document.addEventListener("DOMContentLoaded", () => {
    const active = document.querySelector("nav a.active");
    if (active) {
        // Transition tijdelijk uitzetten zodat hij NIET opnieuw omlaag schuift
        active.style.transition = "none";

        // In de volgende render-tick transition weer aanzetten
        requestAnimationFrame(() => {
            active.style.transition = "";
        });
    }
});

// --- 4. Dynamisch jaartal in footer (nodig omdat footer via fetch wordt geladen) ---
const footerObserver = new MutationObserver(() => {
    const yearElem = document.getElementById("year");
    if (yearElem && !yearElem.textContent) {
        yearElem.textContent = new Date().getFullYear();
    }
});
footerObserver.observe(document.body, { childList: true, subtree: true });

