<?php
require_once "app/core/Database.php";

class User {

    public static function findByUsername($username) {

        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllCustomers() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}