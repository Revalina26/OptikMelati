<?php
include "config/config.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        die(json_encode(['error' => 'Connection failed']));
    }
    
    $query = "SELECT id, name, category, price, stock, description FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
    
    mysqli_close($conn);
} else {
    echo json_encode(['error' => 'ID not provided']);
}
?>
