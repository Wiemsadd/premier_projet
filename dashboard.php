<?php
session_start();
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once '../includes/config.php';

// Récupérer les managers
$courseManager = new CourseManager();
$userManager = new UserManager();

// Récupérer les données pour le dashboard
$totalCourses = count($courseManager->getAll());
$totalUsers = count($userManager->getAll());
$totalEnrollments = $userManager->getTotalEnrollments(); // Assurez-vous que cette méthode existe
$enrollmentsData = $userManager->getEnrollmentsByMonth();
$coursesByCategory = $courseManager->getCoursesByCategory();
$revenueByMonth = $courseManager->getRevenueByMonth();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - EduShop</title>
    <script src="https://cdn.tailwindcss.com "></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js "></script>

    <?php include '../includes/navbar.php';
     ?>
</head>
<body class="bg-gray-100">


<h2 class="text-3xl font-bold mb-6">Tableau de bord</h2>

<a href="add_course.php" class="inline-block mb-6 button-61 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
    ➕ Ajouter un cours
</a>
<main class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">Tableau de bord</h2>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700">Cours Total</h3>
            <p class="text-3xl font-bold text-indigo-600"><?= $totalCourses ?></p>
        </div>

        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700">Utilisateurs</h3>
            <p class="text-3xl font-bold text-indigo-600"><?= $totalUsers ?></p>
        </div>

        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700">Inscriptions</h3>
            <p class="text-3xl font-bold text-indigo-600"><?= $totalEnrollments ?></p>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold text-lg mb-4">Inscriptions par mois</h3>
            <canvas id="enrollmentsChart" height="100"></canvas>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold text-lg mb-4">Cours par catégorie</h3>
            <canvas id="coursesByCategoryChart" height="100"></canvas>
        </div>

        <div class="bg-white p-6 rounded shadow col-span-full">
            <h3 class="font-semibold text-lg mb-4">Revenus par mois</h3>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const enrollmentsCtx = document.getElementById('enrollmentsChart').getContext('2d');
    new Chart(enrollmentsCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_map(function($d) { return $d['date']; }, $enrollmentsData)) ?>,
            datasets: [{
                label: 'Inscriptions',
                data: <?= json_encode(array_map(function($d) { return $d['count']; }, $enrollmentsData)) ?>,
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: false },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    const categoryCtx = document.getElementById('coursesByCategoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($coursesByCategory)) ?>,
            datasets: [{
                label: 'Nombre de cours',
                data: <?= json_encode(array_values($coursesByCategory)) ?>,
                backgroundColor: '#6366F1'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: false },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_map(function($d) { return $d['date']; }, $revenueByMonth)) ?>,
            datasets: [{
                label: 'Revenus',
                data: <?= json_encode(array_map(function($d) { return $d['amount']; }, $revenueByMonth)) ?>,
                backgroundColor: ['#8B5CF6', '#EC4899', '#F59E0B', '#10B981', '#3B82F6']
            }]
        },
        options: {
            responsive: true
        }
    });
});
</script>

</body>
</html>