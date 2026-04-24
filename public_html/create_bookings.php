<?php
require 'config/config.php';
require 'app/core/Database.php';
$db = Database::connect();
$db->exec("CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100), 
    phone VARCHAR(20), 
    message TEXT, 
    status VARCHAR(20) DEFAULT 'Pending', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
echo "Done";

