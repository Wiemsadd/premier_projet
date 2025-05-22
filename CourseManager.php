<?php
require_once 'Course.php';
require_once 'Database.php';


class CourseManager {
    public function getAll() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM courses");
        $courses = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['price'],
                $row['category_id'],
                $row['image']
            );
        }
        return $courses;
    }
    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO courses (title, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $data['image']
        ]);
    }

    public function getById($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Course(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['price'],
                $row['category_id'],
                $row['image']
            );
        }
        return null;
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE courses SET title = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $data['image'],
            $id
        ]);
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCoursesByCategory() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT category_id, COUNT(*) AS count FROM courses GROUP BY category_id");
        $result = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $result[$row['category_id']] = $row['count'];
        }
        return $result;
    }

    public function getRevenueByMonth() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT DATE_FORMAT(e.purchased_at, '%Y-%m') AS date, SUM(c.price) AS amount 
                             FROM enrollments e 
                             JOIN courses c ON e.course_id = c.id 
                             GROUP BY date ORDER BY date");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnrollmentsByMonth() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT DATE_FORMAT(purchased_at, '%Y-%m') AS date, COUNT(*) AS count 
                             FROM enrollments GROUP BY date ORDER BY date");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalEnrollments() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM enrollments");
        return $stmt->fetchColumn();
    }

    public function getByCategoryId($categoryId) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $courses = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['price'],
                $row['category_id'],
                $row['image']
            );
        }
        return $courses;
    }
}
?>
