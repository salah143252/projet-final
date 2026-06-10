// ===================================
// ParaCare - Script JavaScript
// Parapharmacie en Ligne
// ===================================

// --- Menu burger mobile ---
// Ouvre/ferme le menu de navigation sur mobile
function toggleMenu() {
    var navLinks = document.getElementById('navLinks');
    if (navLinks) {
        navLinks.classList.toggle('active');
    }
}

// --- Quantite sur la page detail produit ---
// Diminuer la quantite
function diminuerQte() {
    var input = document.getElementById('quantite');
    if (input) {
        var valeur = parseInt(input.value);
        if (valeur > 1) {
            input.value = valeur - 1;
        }
    }
}

// Augmenter la quantite
function augmenterQte(stockMax) {
    var input = document.getElementById('quantite');
    if (input) {
        var valeur = parseInt(input.value);
        if (valeur < stockMax) {
            input.value = valeur + 1;
        }
    }
}

// --- Onglets sur la page detail produit ---
function ouvrirOnglet(event, idOnglet) {
    // Cacher tous les contenus
    var contenus = document.querySelectorAll('.onglet-content');
    for (var i = 0; i < contenus.length; i++) {
        contenus[i].classList.remove('active');
    }

    // Desactiver tous les boutons
    var boutons = document.querySelectorAll('.onglet-btn');
    for (var i = 0; i < boutons.length; i++) {
        boutons[i].classList.remove('active');
    }

    // Activer l'onglet clique
    document.getElementById(idOnglet).classList.add('active');
    event.currentTarget.classList.add('active');
}

// --- Menu deroulant categories ---
function toggleDropdown(event) {
    event.stopPropagation();
    var dropdown = document.getElementById('catDropdown');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
}

// --- Newsletter footer (inscription en base) ---
function inscrireNewsletter(event) {
    event.preventDefault();
    var emailInput = document.getElementById('newsletterEmail');
    var msg = document.getElementById('newsletterMsg');
    if (!emailInput || !msg) return false;

    var formData = new FormData();
    formData.append('email', emailInput.value.trim());

    fetch('index.php?page=newsletter', {
        method: 'POST',
        body: formData
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        msg.textContent = data.message;
        msg.style.color = data.success ? '#27AE60' : '#e74c3c';
        if (data.success) emailInput.value = '';
    })
    .catch(function() {
        msg.textContent = 'Erreur réseau. Réessayez plus tard.';
        msg.style.color = '#e74c3c';
    });

    return false;
}

// --- Menu admin mobile ---
function toggleAdminSidebar() {
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('adminOverlay');
    if (sidebar) sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('open');
}

// --- Scroll-triggered animations ---
document.addEventListener('DOMContentLoaded', function() {
    // Add scroll animation class to sections
    const sections = document.querySelectorAll('.section, .promo-banner, .infos-section, .marques-section');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    sections.forEach(function(section) {
        section.classList.add('animate-on-scroll');
        observer.observe(section);
    });
});

// --- Fermer le menu mobile et dropdown quand on clique en dehors ---
document.addEventListener('click', function(e) {
    var navLinks = document.getElementById('navLinks');
    var menuToggle = document.querySelector('.menu-toggle');
    var dropdown = document.getElementById('catDropdown');

    if (navLinks && navLinks.classList.contains('active')) {
        if (!navLinks.contains(e.target) && menuToggle && !menuToggle.contains(e.target)) {
            navLinks.classList.remove('active');
        }
    }

    if (dropdown && dropdown.classList.contains('show')) {
        if (!e.target.closest('.nav-dropdown')) {
            dropdown.classList.remove('show');
        }
    }
});
