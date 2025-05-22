// Fonction scrollAppear pour "À propos"
function scrollAppear() {
    const introText = document.querySelector('.side-text');
    const sideImage = document.querySelector('.sideImage');
    const introPosition = introText?.getBoundingClientRect().top;
    const imagePosition = sideImage?.getBoundingClientRect().top;
    const screenPosition = window.innerHeight / 1.2;
    if (introText && introPosition < screenPosition) {
        introText.classList.add('side-text-appear');
    }
    if (sideImage && imagePosition < screenPosition) {
        sideImage.classList.add('sideImage-appear');
    }
}
window.addEventListener('scroll', scrollAppear);

// Toggle menu mobile
var i = 2;
function switchTAB() {
    var x = document.getElementById("list-switch");
    var y = document.getElementById("search-switch");
    if(i % 2 === 0) {
        x.style.display = "block";
        y.style.display = "block";
    } else {
        x.style.display = "none";
        y.style.display = "none";
    }
    i++;
}

// Toggle dark mode
function setupDarkMode() {
    const body = document.body;
    const toggle = document.getElementById('darkModeToggle');
    const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
    if (isDarkMode) {
        body.classList.add('dark-mode');
        toggle.classList.add('active');
    }
    toggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        toggle.classList.toggle('active');
        const mode = body.classList.contains('dark-mode') ? 'enabled' : 'disabled';
        localStorage.setItem('darkMode', mode);
    });
}
document.addEventListener('DOMContentLoaded', setupDarkMode);

// Menu mobile
function sideMenu(side) {
    const menu = document.getElementById('side-menu');
    if (side === 0) {
        menu.style.transform = 'translateX(0)';
        menu.style.position = 'fixed';
    } else {
        menu.style.transform = 'translateX(-100%)';
    }
}

// Recherche interactive
function searchdisplay() {
    const input = document.querySelector('.search');
    const term = input.value.trim().toLowerCase();
    if (!term) {
        alert("Veuillez entrer un terme de recherche.");
        return;
    }
    let found = false;
    document.querySelectorAll('*').forEach(el => {
        if (el.textContent.toLowerCase().includes(term)) {
            el.style.backgroundColor = '#ffffcc';
            el.scrollIntoView({ behavior: 'smooth' });
            found = true;
        } else {
            el.style.backgroundColor = '';
        }
    });
    if (!found) {
        alert(`"${term}" non trouvé.`);
    } else {
        alert(`"${term}" trouvé sur la page.`);
    }
}

// Animation au chargement des éléments
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".card").forEach(card => {
        card.style.opacity = "0";
        setTimeout(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 300);
    });
}); 