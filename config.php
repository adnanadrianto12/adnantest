<?php
$host = 'sql213.infinityfree.com'; // Host database di InfinityFree
$db_name = 'if0_37810105_scores'; // Nama database Anda
$username = 'if0_37810105'; // Username MySQL
$password = 'DyJJBW6jyRbG'; // Password MySQL

// Koneksi dengan MySQLi
$conn = new mysqli($host, $username, $password, $db_name);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>
