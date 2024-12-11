<?php
$host = 'sql213.infinityfree.com';
$db_name = 'if0_37810105_scores';
$username = 'if0_37810105';
$password = 'DyJJBW6jyRbG';

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
