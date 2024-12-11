<?php
$host = 'sql213.infinityfree.com';
$db_name = 'if0_37810105_scores';
$username = 'if0_37810105';
$password = 'DyJJBW6jyRbG';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
