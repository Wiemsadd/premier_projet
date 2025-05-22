<?php
// Vérifie si la session est active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userRole = $_SESSION['user']['role'] ?? null;
$userId = $_SESSION['user']['id'] ?? null;
?>

<!-- NAVBAR -->
<nav class="bg-white shadow p-4 flex justify-between items-center fixed w-full top-0 z-50">
    <div class="logo flex items-center">
        <a href="<?= $userRole ? '../index.php' : 'index.php' ?>">
            <img src="../images/logo.jpg" alt="Logo EduShop" class="h-10 w-auto" />
        </a>
        <span class="ml-2 text-xl font-bold text-indigo-600">EduShop</span>
    </div>

    <!-- Navigation principale -->
    <ul class="desktop-nav hidden md:flex space-x-6">
        <li><a href="../index.php" class="<?= ($_SERVER['PHP_SELF'] == '/index.php') ? 'active' : '' ?>">Accueil</a></li>
        <li><a href="../courses.php">Cours</a></li> <!-- Bouton Cours ajouté ici -->
        <?php if ($userRole === 'admin'): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
        <?php elseif ($userRole === 'student'): ?>
            <li><a href="../cours.php">Mes Cours</a></li>
        <?php endif; ?>
        <li><a href="#portfolio_section">Portfolio</a></li>
        <li><a href="#services_section">Services</a></li>
        <li><a href="#contactus_section">Contact</a></li>
    </ul>

    <!-- Connexion/Déconnexion -->
    <div class="space-x-4 hidden md:block">
        <?php if ($userRole): ?>
            <a href="../courses.php" class="text-indigo-600 hover:text-indigo-800">Liste des Cours</a>
            <?php if ($userRole === 'admin'): ?>
                <a href="dashboard.php" class="text-indigo-600 hover:text-indigo-800">Dashboard</a>
                <a href="../logout.php" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Déconnexion</a>
            <?php else: ?>
                <a href="../logout.php" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Déconnexion</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="../login.php" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Connexion</a>
        <?php endif; ?>
    </div>

    <!-- Menu Burger pour mobile -->
    <img src="../images/icon/menu.png" class="menu h-6 w-6 cursor-pointer md:hidden" onclick="toggleMobileMenu()" />
</nav>

<!-- Side Menu Mobile -->
<div id="mobile-menu" class="fixed right-0 top-0 h-full w-64 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="p-4 border-b flex justify-between items-center">
        <span>Menu</span>
        <button onclick="toggleMobileMenu()" class="text-gray-500">×</button>
    </div>
    <ul class="flex flex-col p-4 space-y-4">
        <li><a href="../index.php" class="block py-2 px-4 hover:bg-gray-100">🏠 Accueil</a></li>
        <li><a href="../courses.php" class="block py-2 px-4 hover:bg-gray-100">📚 Tous les Cours</a></li>
        <?php if ($userRole === 'admin'): ?>
            <li><a href="dashboard.php" class="block py-2 px-4 hover:bg-gray-100">📊 Dashboard</a></li>
            <li><a href="add_course.php" class="block py-2 px-4 hover:bg-gray-100">➕ Ajouter un cours</a></li>
            <li><a href="../logout.php" class="block py-2 px-4 bg-red-100 text-red-700 rounded">🔴 Déconnexion</a></li>
        <?php elseif ($userRole === 'student'): ?>
            <li><a href="../my-courses.php" class="block py-2 px-4 hover:bg-gray-100">📖 Mes cours</a></li>
            <li><a href="../logout.php" class="block py-2 px-4 bg-red-100 text-red-700 rounded">🔴 Déconnexion</a></li>
        <?php else: ?>
            <li><a href="../login.php" class="block py-2 px-4 bg-indigo-100 text-indigo-700 rounded">👤 Connexion</a></li>
        <?php endif; ?>
    </ul>
</div>

<!-- Dark Mode Toggle -->
<div class="dark-mode-toggle" id="darkModeToggle" onclick="toggleDarkMode()">
    <span class="sun">☀️</span>
    <span class="moon">🌙</span>
    <span class="toggle-ball"></span>
</div>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('translate-x-full');
}

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const toggle = document.getElementById('darkModeToggle');
    toggle.classList.toggle('active');

    // Enregistrer le thème dans localStorage
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}

// Charger le thème au démarrage
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        document.getElementById('darkModeToggle').classList.add('active');
    }
});
</script>