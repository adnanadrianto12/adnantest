<?php
$host = 'sql213.infinityfree.com'; // Host database di InfinityFree
$db_name = 'if0_37810105_scores'; // Nama database Anda
$username = 'if0_37810105'; // Username MySQL
$password = 'DyJJBW6jyRbG'; // Password MySQL

// Menggunakan PDO untuk menghubungkan ke database MySQL
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
