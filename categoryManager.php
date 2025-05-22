<?php
require_once 'Database.php';

class CategoryManager {
    public function getAll() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM categories");
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(
                $row['id'],
                $row['name']
            );
        }
        return $categories;
    }

    public function getById($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Category($row['id'], $row['name']);
        }
        return null;
    }

    public function create($data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        return $stmt->execute([$data['name']]);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $id]);
    }

    public function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>