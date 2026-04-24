<?php
require_once BASE_PATH . "/app/core/Database.php";

class Product {

    public static function getAll($limit = 6, $offset = 0, $search = null, $sort = null, $category = null) {

        $db = Database::connect();
        $where = [];
        $params = [];

        if ($search) {
            $where[] = "name LIKE ?";
            $params[] = "%$search%";
        }

        if ($category) {
            $where[] = "category = ?";
            $params[] = $category;
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";
        $order = $sort ? "ORDER BY price " . ($sort === 'asc' ? 'ASC' : 'DESC') : "";

        $sql = "SELECT * FROM products $whereSQL $order LIMIT $limit OFFSET $offset";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countAll($search = null, $category = null) {

        $db = Database::connect();
        $where = [];
        $params = [];

        if ($search) {
            $where[] = "name LIKE ?";
            $params[] = "%$search%";
        }

        if ($category) {
            $where[] = "category = ?";
            $params[] = $category;
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

        $stmt = $db->prepare("SELECT COUNT(*) FROM products $whereSQL");
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }

    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $price, $stock, $image, $category) {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO products (name, price, stock, image, category)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $price, $stock, $image, $category]);
    }

    public static function update($id, $name, $price, $stock, $category) {
        $db = Database::connect();
        $stmt = $db->prepare("
            UPDATE products
            SET name = ?, price = ?, stock = ?, category = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $price, $stock, $category, $id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getAllAdmin() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateWithImage($id, $name, $price, $stock, $category, $image) {

        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE products
            SET name = ?, price = ?, stock = ?, category = ?, image = ?
            WHERE id = ?
        ");

        return $stmt->execute([$name, $price, $stock, $category, $image, $id]);
    }

    public static function countLowStock() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) as total FROM products WHERE stock < 5");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
}