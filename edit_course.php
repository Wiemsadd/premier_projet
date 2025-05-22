<?php
include 'header.php';
$courseId = $_GET['id'] ?? null;

if (!$courseId) {
    echo "<p>Cours introuvable.</p>";
    exit;
}

require_once '../includes/CourseManager.php';
$manager = new CourseManager();
$course = $manager->getById($courseId);

if (!$course) {
    echo "<p>Cours introuvable.</p>";
    exit;
}
?>

<h1 class="text-2xl font-bold mb-6">Modifier le cours</h1>

<form method="POST" action="save_course.php" class="space-y-4">
    <input type="hidden" name="id" value="<?= $course->getId() ?>">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
        <input type="text" name="title" value="<?= htmlspecialchars($course->getTitle()) ?>" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" required class="w-full border border-gray-300 rounded px-3 py-2"><?= htmlspecialchars($course->getDescription()) ?></textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
        <input type="number" step="0.01" name="price" value="<?= $course->getPrice() ?>" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
        <input type="text" name="category" value="<?= htmlspecialchars($course->getCategory()) ?>" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Image (URL)</label>
        <input type="text" name="image" value="<?= htmlspecialchars($course->getImage()) ?>" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
</form>

<?php include 'footer.php'; ?>