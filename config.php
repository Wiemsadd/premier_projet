<?php
session_start();
define('ROOT', dirname(__DIR__));
require_once ROOT . '/includes/Database.php';
require_once ROOT . '/includes/User.php';
require_once ROOT . '/includes/UserManager.php';
require_once ROOT . '/includes/Course.php';
require_once ROOT . '/includes/CourseManager.php';
?>