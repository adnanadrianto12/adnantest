<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track User Location</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        #location {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
            display: inline-block;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Welcome to Location Tracker</h1>
    <p>Your location will be displayed below:</p>
    <div id="location">
        <p>Loading...</p>
    </div>

    <script>
        // Panggil backend untuk mendapatkan lokasi
        fetch('track.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('location').innerHTML = `
                        <strong>IP Address:</strong> ${data.ip} <br>
                        <strong>City:</strong> ${data.city} <br>
                        <strong>Region:</strong> ${data.region} <br>
                        <strong>Country:</strong> ${data.country} <br>
                        <strong>Latitude:</strong> ${data.latitude} <br>
                        <strong>Longitude:</strong> ${data.longitude}
                    `;
                } else {
                    document.getElementById('location').textContent = 'Unable to fetch location.';
                }
            })
            .catch(error => {
                document.getElementById('location').textContent = 'Error fetching location.';
                console.error('Error:', error);
            });
    </script>
</body>
</html>
