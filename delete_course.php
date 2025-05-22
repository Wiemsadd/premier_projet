<?php
session_start();
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$courseId = $_POST['id'] ?? null;

if (!$courseId) {
    echo "ID du cours manquant.";
    exit;
}

require_once '../includes/CourseManager.php';
$manager = new CourseManager();
$manager->delete($courseId);

header("Location: courses.php");
exit;
?>