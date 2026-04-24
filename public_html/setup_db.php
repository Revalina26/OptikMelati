<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';

try {
    $db = Database::connect();
    
    // Create invoices table
    $sql = "CREATE TABLE IF NOT EXISTS invoices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE NOT NULL,
        no_nota VARCHAR(50) NULL,
        nama VARCHAR(100) NOT NULL,
        no_hp VARCHAR(20) NOT NULL,
        resep_dari VARCHAR(100) NULL,
        frame VARCHAR(100) NULL,
        lensa VARCHAR(100) NULL,
        r_sph VARCHAR(20) NULL,
        r_cyl VARCHAR(20) NULL,
        r_as VARCHAR(20) NULL,
        l_sph VARCHAR(20) NULL,
        l_cyl VARCHAR(20) NULL,
        l_as VARCHAR(20) NULL,
        add_lens VARCHAR(50) NULL,
        pd_jauh VARCHAR(20) NULL,
        pd_dekat VARCHAR(20) NULL,
        jumlah DECIMAL(10,2) NOT NULL DEFAULT 0,
        uang_muka DECIMAL(10,2) NOT NULL DEFAULT 0,
        metode_dp VARCHAR(50) NULL,
        sisa DECIMAL(10,2) NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($sql);
    echo "Table 'invoices' created successfully!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
