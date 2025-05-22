<?php
require_once 'includes/config.php';
$manager = new CourseManager();
$courses = $manager->getAll();
$categories = array_unique(array_map(function($c) { return $c->getCategory(); }, $courses));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tous les Cours - EduShop</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }
        .filter-btn {
            padding: 10px 20px;
            border: none;
            background-color: #4F46E5;
            color: white;
            border-radius: 999px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .filter-btn:hover {
            background-color: #6366F1;
        }
        .filter-btn.active {
            background-color: #4338CA;
        }
        .course-item {
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .course-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .course-thumbnail {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-level {
            display: inline-block;
            background: rgba(79, 70, 229, 0.1);
            color: #4F46E5;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            margin: 1rem;
        }
        .course-title {
            font-size: 1.25rem;
            font-weight: 600;
            padding: 0 1rem;
            margin-bottom: 0.5rem;
        }
        .line {
            height: 1px;
            background: #e5e7eb;
            margin: 0.5rem 1rem;
        }
        .course-price-section {
            display: flex;
            align-items: center;
            padding: 0 1rem;
            margin-bottom: 1rem;
        }
        .final-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1E293B;
            margin-right: 0.5rem;
        }
        .prev-price {
            text-decoration: line-through;
            color: #94a3b8;
            margin-right: 0.5rem;
        }
        .discount-percent {
            background: #10b981;
            color: white;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .button-61 {
            background-color: #4F46E5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            margin: 0 1rem 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        .button-61:hover {
            background-color: #6366F1;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!-- Section Titre -->
<section class="mb-12">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">
            Tous nos <span class="text-primary">Cours</span>
        </h2>
        <p class="text-lg text-gray-700 mb-6">
            Découvrez notre catalogue complet de formations à prix abordables.
        </p>
    </div>
</section>

<!-- Filtres -->
<div class="filter-container container mx-auto px-4 mb-8">
    <button class="filter-btn active" data-filter="all">Tous</button>
    <?php foreach ($categories as $category): ?>
        <button class="filter-btn" data-filter="<?= strtolower($category) ?>">
            <?= htmlspecialchars($category) ?>
        </button>
    <?php endforeach; ?>
</div>

<!-- Grille des cours -->
<section>
    <div class="container mx-auto px-4">
        <div id="courseGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="course-item" data-category="<?= strtolower(htmlspecialchars($course->getCategory())) ?>">
                        <img src="<?= htmlspecialchars($course->getImage()) ?>" alt="<?= htmlspecialchars($course->getTitle()) ?>" class="course-thumbnail">
                        <p class="card-level"><?= htmlspecialchars($course->getCategory()) ?></p>
                        <h3 class="course-title"><?= htmlspecialchars($course->getTitle()) ?></h3>
                        <p class="line"></p>
                        <div class="course-price-section">
                            <span class="final-price"><?= number_format($course->getPrice(), 2) ?> €</span>
                            <span class="prev-price"><?= number_format($course->getPrice() * 1.2, 2) ?> €</span>
                            <span class="discount-percent">-20%</span>
                        </div>
                        <a href="course.php?id=<?= $course->getId() ?>" class="button-61 block text-center mt-4">
                            Voir détails
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun cours disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<script>
// Filtre dynamique par catégorie
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const filter = btn.getAttribute('data-filter');

        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.course-item').forEach(item => {
            item.style.display = filter === 'all' || item.getAttribute('data-category') === filter ? 'block' : 'none';
        });
    });
});
</script>

</body>
</html>
