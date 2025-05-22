<?php
session_start();
require_once 'includes/Database.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification dans la base de données
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $password === $user['password']) { // Note: en production, utilisez password_hash/password_verify
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $error = "Erreur de connexion à la base de données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - EduShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>
        <?php if ($error): ?>
            <p class="text-red-500 mb-4"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Se connecter</button>
        </form>
    </div>
</body>
</html>
