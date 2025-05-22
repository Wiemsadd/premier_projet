<?php
require_once 'User.php';
require_once 'Database.php';

class UserManager {
    public function getAll() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM users");
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        }
        return $users;
    }
    public function getRevenueByMonth() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT DATE_FORMAT(e.purchased_at, '%Y-%m') AS date, SUM(c.price) AS amount 
                             FROM enrollments e
                             JOIN courses c ON e.course_id = c.id
                             GROUP BY date ORDER BY date");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }public function getCoursesByCategory() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT category, COUNT(*) AS count FROM courses GROUP BY category");
        $result = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $result[$row['category']] = $row['count'];
        }
        return $result;
    }
    public function getTotalEnrollments() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM enrollments");
        return $stmt->fetchColumn();
    }
    public function getEnrollmentsByMonth() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT DATE_FORMAT(purchased_at, '%Y-%m') AS date, COUNT(*) AS count 
                             FROM enrollments GROUP BY date ORDER BY date");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getLatest() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        }
        return null;
    }
}

?>
