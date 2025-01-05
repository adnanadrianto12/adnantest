<?php
// Konfigurasi database
$host = 'sql213.infinityfree.com';
$username = 'if0_37810105';
$password = 'DyJJBW6jyRbG';
$database = 'if0_37810105_scores';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Dapatkan alamat IP pengguna
$ip = $_SERVER['REMOTE_ADDR'];

// Gunakan layanan geolokasi berbasis IP
$apiUrl = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($apiUrl);
$locationData = json_decode($response, true);

if ($locationData && $locationData['status'] === 'success') {
    // Ambil data lokasi
    $city = $locationData['city'];
    $region = $locationData['regionName'];
    $country = $locationData['country'];
    $latitude = $locationData['lat'];
    $longitude = $locationData['lon'];

    // Simpan ke database
    $stmt = $conn->prepare(
        "INSERT INTO location_logs (ip_address, city, region, country, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssssdd", $ip, $city, $region, $country, $latitude, $longitude);
    $stmt->execute();
    $stmt->close();

    // Tampilkan lokasi
    echo json_encode([
        'status' => 'success',
        'ip' => $ip,
        'city' => $city,
        'region' => $region,
        'country' => $country,
        'latitude' => $latitude,
        'longitude' => $longitude,
    ]);
} else {
    // Gagal mendapatkan lokasi
    echo json_encode(['status' => 'error', 'message' => 'Unable to determine location.']);
}

// Tutup koneksi
$conn->close();
?>
