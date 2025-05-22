<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduShop - Plateforme de cours en ligne</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#6366F1',
                        dark: '#1E293B',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="index.php" class="flex items-center space-x-2">
                    <img src="./images/logo.jpg" alt="Logo EduShop" class="h-12 w-auto rounded">
                    <span class="text-2xl font-bold text-primary">EduShop</span>
                </a>
                <nav class="flex items-center space-x-6">
                    <a href="./index.php" class="text-dark hover:text-primary transition-colors font-medium">Accueil</a>
                    <a href="./courses.php" class="text-dark hover:text-primary transition-colors font-medium">Cours</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <a href="admin/dashboard.php" class="text-dark hover:text-primary transition-colors font-medium">Administration</a>
                        <?php endif; ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-1 text-dark hover:text-primary transition-colors font-medium">
                                <span>Mon compte</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                                <a href="./profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                                <a href="./my-courses.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes cours</a>
                                <a href="./logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Déconnexion</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="./login.php" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-secondary transition-colors">Connexion</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <main class="flex-grow container mx-auto px-4 py-8">

