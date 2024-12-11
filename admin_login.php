<?php
// Menghubungkan ke file config.php untuk koneksi database
include 'config.php';
session_start();

// Cek jika sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Variabel untuk pesan error
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk memeriksa username
    $query = "SELECT * FROM admin_users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

if (password_verify($password, $user['password'])) {
    // Perbarui kolom in_game menjadi 1
    $update_query = "UPDATE admin_users SET in_game = 1 WHERE username = '$username'";
    if (mysqli_query($conn, $update_query)) {
        // Set sesi username
$_SESSION['username'] = $user['username'];
$_SESSION['is_superadmin'] = (strtolower($user['username']) === 'js'); // Tandai superadmin (case-insensitive)
        header("Location: admin.php");
        exit();
    } else {
        $error_message = "Gagal memperbarui status login. Coba lagi.";
    }
}
 else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
/* Gaya untuk body */
/* Gaya untuk body */
body {
    background: linear-gradient(145deg, #0d0d0d, #1a1a1a);
    color: #e0e0e0;
    font-family: 'Roboto', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    overflow: hidden;
}

/* Container login */
.login-container {
    background: linear-gradient(145deg, #1e1e1e, #2b2b2b);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
    border-radius: 12px;
    padding: 30px;
    width: 100%;
    max-width: 400px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Header dalam container */
.login-container h1 {
    font-size: 26px;
    margin-bottom: 20px;
    text-align: center;
    color: #ffffff;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
}

/* Input dan Placeholder */
.form-control {
    background-color: #2b2b2b; /* Warna latar belakang input */
    color: #f0f0f0; /* Warna teks input */
    border: 1px solid #444; /* Border */
    border-radius: 6px;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:hover,
.form-control:focus {
    background-color: #333; /* Warna saat hover/fokus */
    border-color: #666; /* Border saat fokus */
    color: #ffffff; /* Pastikan teks tetap terlihat */
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.2); /* Efek fokus */
}

.form-control::placeholder {
    color: #888; /* Placeholder abu-abu */
    opacity: 1; /* Placeholder terlihat jelas */
}

.form-control:focus::placeholder {
    color: #555; /* Placeholder lebih gelap saat fokus */
}

/* Tombol */
.btn-primary, .btn-secondary {
    border: none;
    transition: all 0.4s;
    border-radius: 5px;
    font-size: 16px;
    padding: 10px 15px;
    cursor: pointer;
    width: 100%;
    margin-bottom: 10px;
}

.btn-primary {
    background: linear-gradient(145deg, #3a3a3a, #4f4f4f);
    color: #ffffff;
}

.btn-primary:hover {
    background: linear-gradient(145deg, #575757, #686868);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.btn-secondary {
    background: linear-gradient(145deg, #444, #555);
    color: #ffffff;
}

.btn-secondary:hover {
    background: linear-gradient(145deg, #666, #777);
    transform: scale(1.05);
}

/* Ikon Input */
.input-group-text {
    background-color: #2b2b2b;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    padding: 0 10px;
    cursor: pointer;
    transition: all 0.3s;
}

.input-group-text:hover {
    background-color: #333;
}

.eye-icon {
    cursor: pointer;
    font-size: 16px;
    color: #aaa;
    transition: color 0.3s;
}

.eye-icon:hover {
    color: #fff;
}

/* Alert */
.alert {
    background-color: #700000;
    color: #ffffff;
    border: 1px solid #ff4d4d;
    padding: 10px;
    border-radius: 5px;
    animation: shake 0.5s ease-out;
}

/* Animasi */
@keyframes slideIn {
    from {
        transform: translateY(50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes shake {
    0% { transform: translateX(-10px); }
    25% { transform: translateX(10px); }
    50% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
    100% { transform: translateX(0); }
}


    </style>
</head>
<body>
<div class="login-container">
    <h1><i class="fas fa-user-shield"></i> Admin Login</h1>
<?php if ($error_message): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>
    <form method="POST" action="" class="mt-3">
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            <span class="input-group-text eye-icon" onclick="togglePassword()"><i id="toggleEye" class="fas fa-eye"></i></span>
        </div>
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt"></i> Login</button>
        <a href="index.php" class="btn btn-secondary w-100 mt-2"><i class="fas fa-home"></i> Kembali ke Index</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const toggleEye = document.getElementById('toggleEye');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleEye.classList.remove('fa-eye');
            toggleEye.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleEye.classList.remove('fa-eye-slash');
            toggleEye.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
