<?php include 'header.php'; ?>
<h1 class="text-2xl font-bold mb-6">Ajouter un cours</h1>

<form method="POST" action="save_course.php" class="space-y-4 bg-white p-6 rounded shadow">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
        <input type="text" name="title" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" required class="w-full border border-gray-300 rounded px-3 py-2 h-32"></textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
        <input type="number" step="0.01" name="price" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
        <input type="text" name="category" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Image (URL)</label>
        <input type="text" name="image" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    <div class="flex space-x-4">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700" >Enregistrer</button>
        <a href="courses.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Annuler</a>
    </div>
</form>

<?php include 'footer.php'; ?>
