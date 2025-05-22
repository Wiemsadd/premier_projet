<?php
require_once 'Review.php';
require_once 'Database.php';

class ReviewManager {
    public function getAll() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5");
        $reviews = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reviews[] = new Review(
                $row['id'],
                $row['user_name'],
                $row['course_title'],
                $row['rating'],
                $row['message']
            );
        }
        return $reviews;
    }

    public function add($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO reviews (user_name, course_title, rating, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['user_name'],
            $data['course_title'],
            $data['rating'],
            $data['message']
        ]);
    }
}
?>