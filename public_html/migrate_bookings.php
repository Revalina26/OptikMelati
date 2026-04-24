<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';

try {
    $db = Database::connect();
    
    // Add payment_info column
    $sql = "ALTER TABLE bookings ADD COLUMN payment_info VARCHAR(255) DEFAULT NULL";
    
    $db->exec($sql);
    echo "Column 'payment_info' added successfully!\n";
    
} catch (PDOException $e) {
    echo "Error (or already exists): " . $e->getMessage() . "\n";
}
?>
