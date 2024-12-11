<?php include 'config.php'; 

if (!extension_loaded('mysqli')) {
    die('Ekstensi MySQLi tidak tersedia.');
} else {
    echo 'Ekstensi MySQLi tersedia.';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Poker Scoreboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Pastikan background full tanpa abu-abu */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('img/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            animation: fadeIn 2s ease;
        }

        /* Animasi fade-in */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-family: 'Roboto', sans-serif;
            font-size: 2.5rem;
            color: white;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.05em;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 10px;
            animation: fadeIn 1.5s ease;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            animation: navbarFade 2s;
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }

        table {
            width: 90%;
            margin: 20px auto;
            animation: slideIn 1.5s ease-out;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            background-color: #2c2c54;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            font-size: 1.3rem;
            color: #f5f6fa;
            font-weight: 700;
            background-color: #40407a;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-bottom: 2px solid #706fd3;
        }

        td {
            font-size: 1.1rem;
            color: #d2dae2;
            background-color: #2c2c54;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        tr:hover td {
            background-color: #474787;
            color: #ffffff;
        }

        .score {
            background-color: #33d9b2;
            color: #fff;
            padding: 5px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 0.9rem;
        }

        tr:not(:last-child) td {
            border-bottom: 1px solid #706fd3;
        }

        .btn {
            transition: transform 0.3s ease, background-color 0.3s;
        }

        .btn:hover {
            transform: scale(1.1);
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 10px;
            }

            .score {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                flex-wrap: wrap;
                justify-content: center;
            }

            .navbar-brand {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.9rem;
            }

            .footer p {
                font-size: 0.8rem;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes navbarFade {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Poker Scoreboard</a>
            <button class="btn btn-light" onclick="location.href='admin_login.php'">
                <i class="fas fa-user-lock"></i> Login Admin
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Papan Skor Poker</h1>

        <!-- Tabel Daftar Pertandingan -->
        <div class="table-responsive">
            <table class="table table-striped table-dark table-hover mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pertandingan</th>
                        <th>Skor</th>
                        <th>Waktu Terakhir Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php';
                    $query = "SELECT id, player_a, player_b, score_a, score_b, last_edited FROM scores ORDER BY id DESC";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            $lastEditedDB = new DateTime($row['last_edited']);
                            $lastEditedDB->modify('+12 hours');
                            $formattedTime = $lastEditedDB->format('H:i:s d/m/Y');

                            echo "<tr>
                                    <td>{$i}</td>
                                    <td>{$row['player_a']} vs {$row['player_b']}</td>
                                    <td><span class='badge bg-success'>{$row['score_a']} - {$row['score_b']}</span></td>
                                    <td>{$formattedTime}</td>
                                  </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>Belum ada data.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Adnan Ganteng | All Rights Reserved</p>
    </div>
</body>
</html>
