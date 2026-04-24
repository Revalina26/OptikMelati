<?php
require_once BASE_PATH . "/app/core/Database.php";

class Booking {
    public static function getAll() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM bookings ORDER BY created_at ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name, $phone, $message, $payment_info = '') {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO bookings (name, phone, message, payment_info, status) VALUES (:name, :phone, :message, :payment_info, 'Belum')");
        return $stmt->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':message' => $message,
            ':payment_info' => $payment_info
        ]);
    }

    public static function update($id, $name, $phone, $message, $payment_info) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE bookings SET name = :name, phone = :phone, message = :message, payment_info = :payment_info WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':phone' => $phone,
            ':message' => $message,
            ':payment_info' => $payment_info
        ]);
    }

    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM bookings WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($id, $status) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE bookings SET status = :status WHERE id = :id");
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
}
