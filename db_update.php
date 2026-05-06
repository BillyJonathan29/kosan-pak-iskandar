<?php
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once 'config/koneksi.php';
require_once 'app/Core/Database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Check if columns exist
    $query = $conn->query("SHOW COLUMNS FROM payments LIKE 'billing_month'");
    if ($query->rowCount() == 0) {
        $conn->exec("ALTER TABLE payments ADD COLUMN billing_month INT NULL DEFAULT 1, ADD COLUMN due_date DATE NULL");
        echo "Columns added successfully.\n";
    } else {
        echo "Columns already exist.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
