<?php
session_start();
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: courses.php");
    exit;
}

$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;
$category = $_POST['category'] ?? '';
$image = $_POST['image'] ?? '';

// Vérifier que les champs obligatoires sont remplis
if (empty($title) || empty($description) || empty($price) || empty($category)) {
    $_SESSION['error'] = "Tous les champs sont obligatoires.";
    if ($id) {
        header("Location: edit_course.php?id=$id");
    } else {
        header("Location: add_course.php");
    }
    exit;
}

require_once '../includes/CourseManager.php';
$manager = new CourseManager();

if ($id) {
    // Mise à jour
    $manager->update($id, [
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'category' => $category,
        'image' => $image
    ]);
} else {
    // Création
    $manager->create([
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'category' => $category,
        'image' => $image
    ]);
}
header("Location: ./cours.php");
exit;
?>
