<?php
require_once "app/core/Database.php";

class Sale {

    public static function getStatistics() {

        $db = Database::connect();

        $stmt = $db->query("
            SELECT DATE(created_at) as date, SUM(total) as total
            FROM sales
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countAll() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) as total FROM sales");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }   

    public static function sumAll() {
        $db = Database::connect();
        $stmt = $db->query("SELECT SUM(total) as total FROM sales");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public static function getTotalRevenue()
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT SUM(total) as total FROM sales");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['total'] ?? 0;
    }

    public static function countOrders()
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) as total FROM sales");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['total'] ?? 0;
    }

    public static function getAll() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM sales ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}