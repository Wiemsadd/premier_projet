<?php
require_once '../includes/config.php';
require_once '../includes/CourseManager.php';
require_once '../includes/CategoryManager.php';

$courseManager = new CourseManager();
$categoryManager = new CategoryManager();

$courses = $courseManager->getAll();
$categories = [];
foreach ($categoryManager->getAll() as $cat) {
    $categories[$cat->getId()] = $cat->getName();
}

include '../includes/navbar.php';
?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Gestion des cours</h2>
    <a href="add_course.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un cours</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($courses)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun cours disponible</td>
                </tr>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $course->getId() ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($course->getTitle()) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($categories[$course->getCategory()] ?? 'Inconnue') ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= number_format($course->getPrice(), 2) ?> €</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="edit_course.php?id=<?= $course->getId() ?>" class="text-blue-600 hover:text-blue-900">Modifier</a>
                            <form method="POST" action="delete_course.php" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
                                <input type="hidden" name="id" value="<?= $course->getId() ?>">
                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


