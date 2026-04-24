<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';
$db = Database::connect();

// Check bookings schema
$stmt = $db->query('DESCRIBE bookings');
echo "BOOKINGS SCHEMA:\n";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

// Check sales schema
$stmt2 = $db->query('DESCRIBE sales');
echo "\nSALES SCHEMA:\n";
print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
?>
