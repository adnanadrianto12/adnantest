<?php
session_start();
include 'config.php';

// Pastikan admin sudah login
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

// Ambil username dari sesi
$username = $_SESSION['username'];

// Ambil data admin berdasarkan username
$query = "SELECT * FROM admin_users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    $admin_username = $admin['username']; // Ambil username admin
} else {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}
$stmt->close();

// Proses input data pertandingan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $player_a = $_POST['player_a'];
    $score_a = $_POST['score_a'];
    $player_b = $_POST['player_b'];
    $score_b = $_POST['score_b'];

    if (!empty($player_a) && !empty($player_b) && is_numeric($score_a) && is_numeric($score_b)) {
        // Gunakan username admin sebagai last_edited_by
        $stmt = $conn->prepare("INSERT INTO scores (player_a, score_a, player_b, score_b, last_edited_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $player_a, $score_a, $player_b, $score_b, $admin_username);

        if ($stmt->execute()) {
            $message = "Data berhasil disimpan!";
        } else {
            $error = "Gagal menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Harap isi semua data dengan benar.";
    }
}

// Ambil semua data pertandingan
$result = $conn->query("SELECT * FROM scores ORDER BY id DESC");
$scores = $result->fetch_all(MYSQLI_ASSOC);

// Hapus data jika `delete_id` ada
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Hanya admin tertentu yang bisa menghapus data
    if ($username !== 'JS') {
        $error = "Jangan gila main apus apus aja.";
    } else {
        $stmt = $conn->prepare("DELETE FROM scores WHERE id = ?");
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $message = "Data berhasil dihapus!";
        } else {
            $error = "Gagal menghapus data: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Arial', sans-serif;
        }
/* General navbar styles */
.navbar {
    background-color: black; /* Warna latar belakang navbar */
    border-bottom: 2px solid #ff4500; /* Tambahkan garis bawah jika perlu */
}

.navbar .navbar-brand {
    color: #ffffff; /* Warna teks logo/brand */
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
}

.navbar .navbar-brand:hover {
    color: #ff4500; /* Warna hover untuk logo/brand */
}

.navbar .nav-link {
    color: #ffffff; /* Warna teks menu */
    font-size: 16px;
    font-weight: 500;
    padding: 10px 15px;
    transition: color 0.3s ease, background-color 0.3s ease;
}

.navbar .nav-link:hover {
    color: #ff4500; /* Warna teks saat hover */
    background-color: #333333; /* Warna latar belakang saat hover */
    border-radius: 5px;
}

.navbar .dropdown-menu {
    background-color: black; /* Latar belakang dropdown */
    border: none; /* Hilangkan border dropdown */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Tambahkan bayangan */
}

.navbar .dropdown-item {
    color: #ffffff; /* Warna teks item dropdown */
    font-size: 15px;
    padding: 10px 20px;
    transition: color 0.3s ease, background-color 0.3s ease;
}

.navbar .dropdown-item:hover {
    color: #ff4500; /* Warna teks saat hover */
    background-color: #444444; /* Warna latar belakang saat hover */
    border-radius: 3px;
}

/* Add toggle animation for dropdown */
.navbar .dropdown-menu {
    display: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.navbar .dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Navbar-toggler for smaller screens */
.navbar-toggler {
    border-color: #ffffff;
}

.navbar-toggler-icon {
    background-color: #ffffff;
}

/* Responsive styles */
@media (max-width: 992px) {
    .navbar .nav-link {
        color: #ffffff;
    }

    .navbar .dropdown-menu {
        position: static;
        transform: none;
        opacity: 1;
        box-shadow: none;
    }
}

        .card {
            background-color: #1f1f1f;
            border: 1px solid #333;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }
        .card-header {
            background-color: #2a2a2a;
            border-bottom: 1px solid #444;
        }
        .btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .btn-success:hover {
            background-color: #28a745 !important;
        }
        .btn-warning:hover {
            background-color: #ffc107 !important;
        }
        table th, table td {
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            background-color: #292929;
            border-bottom: 2px solid #444444;
        }
.alert {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    animation: fadeOut 5s ease forwards;
    width: 300px;
    text-align: center;
}

@keyframes fadeOut {
    0% { opacity: 1; }
    90% { opacity: 0.2; }
    100% { opacity: 0; display: none; }
}


strong {
    font-weight: bold;
    color: #ff5722; /* Warna teks abu-abu gelap */
    border-bottom: 2px solid #007bff; /* Garis bawah biru */
    font-size: 1.2em; /* Sedikit lebih besar */
    padding-bottom: 2px; /* Spasi antara teks dan garis bawah */
}

.dropdown-menu {
    position: absolute;
    top: 100%; /* Posisi dropdown */
    left: 0;
    z-index: 1050;
    display: none; /* Default tersembunyi */
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0;
    background-color: black;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu > .dropdown-menu {
    top: 0;
    left: 100%; /* Geser submenu ke kanan */
    margin-left: 0.1rem;
    margin-right: 0;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item:hover > .dropdown-menu {
    display: block; /* Tampilkan submenu saat hover */
}



    </style>
</head>
<body>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-trophy"></i> Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-home"></i> Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="financeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-calculator"></i> Finance
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="financeDropdown">
                        <li><a class="dropdown-item" href="laporan.php">Laporan Bulanan</a></li>
                        <li><a class="dropdown-item" href="input_data.php">Input Laporan</a></li>
                 
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="financeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-gamepad"></i> Game Menu
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="financeDropdown">
                        <li><a class="dropdown-item" href="game.php">Vs Computer</a></li>
                        <li><a class="dropdown-item" href="input_data.php">Input Laporan</a></li>
                 
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="change_password.php"><i class="fas fa-unlock-alt"></i> Ganti Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <h1>Admin Panel <strong><?= htmlspecialchars($username); ?></strong></p> </h1> 
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Form Tambah Pertandingan -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Tambah Pertandingan Baru</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="player_a" class="form-label">Player A</label>
                        <input type="text" name="player_a" id="player_a" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="player_b" class="form-label">Player B</label>
                        <input type="text" name="player_b" id="player_b" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="score_a" class="form-label">Score A</label>
                        <input type="number" name="score_a" id="score_a" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="score_b" class="form-label">Score B</label>
                        <input type="number" name="score_b" id="score_b" class="form-control" required>
                    </div>
                </div>
                <button type="submit" name="add_match" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> Tambah Pertandingan</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Pertandingan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Player A</th>
                <th>Score A</th>
                <th>Player B</th>
                <th>Score B</th>
                <th>Last Edited By</th>
                <th>Last Edited</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($scores as $score): ?>
            <tr>
                <td><?php echo htmlspecialchars($score['player_a']); ?></td>
                <td><?php echo $score['score_a']; ?></td>
                <td><?php echo htmlspecialchars($score['player_b']); ?></td>
                <td><?php echo $score['score_b']; ?></td>
                <td><?php echo htmlspecialchars($score['last_edited_by']); ?></td>
                <td><?php echo date('Y-m-d H:i:s', strtotime($score['last_edited'] . ' +15 hours')); ?></td>
               <td>
    <a href="edit_score.php?id=<?php echo $score['id']; ?>" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i> Edit
    </a>
    <a href="?delete_id=<?php echo $score['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
        <i class="fas fa-trash"></i> Hapus
    </a>
</td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
