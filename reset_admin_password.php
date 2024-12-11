<?php
session_start();
include 'config.php';
echo "Username: " . $_SESSION['username'] . "<br>";
echo "Superadmin Status: " . ($_SESSION['is_superadmin'] ? "Yes" : "No");



if (!isset($_SESSION['username']) || !isset($_SESSION['is_superadmin']) || !$_SESSION['is_superadmin']) {
    echo "<script>alert('Akses ditolak!'); window.location.href='reset_admin_password.php';</script>";
    exit;
}

// Lanjutkan dengan logika reset password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_admin_username = $_POST['target_admin_username'];
    $new_password = $_POST['new_admin_password'];
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $query = "UPDATE admin_users SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $new_hashed_password, $target_admin_username);

    if ($stmt->execute()) {
        echo "<script>alert('Password admin $target_admin_username berhasil diubah!'); window.location.href='change_password.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah password admin.'); window.location.href='change_password.php';</script>";
    }

    $stmt->close();
}
?>
