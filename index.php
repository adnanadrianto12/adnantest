<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        #location {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            display: inline-block;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Welcome to Location Tracker</h1>
    <p>Your location will be displayed below:</p>
    <div id="location">Fetching location...</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const locationDisplay = document.getElementById("location");

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    // Success callback
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        locationDisplay.textContent = `Latitude: ${latitude}, Longitude: ${longitude}`;
                    },
                    // Error callback
                    (error) => {
                        console.warn(`Geolocation error: ${error.message}`);
                        // Fallback to IP-based location
                        fetch("http://ip-api.com/json/")
                            .then((response) => response.json())
                            .then((data) => {
                                locationDisplay.textContent = `City: ${data.city}, Region: ${data.regionName}, Country: ${data.country}`;
                            })
                            .catch(() => {
                                locationDisplay.textContent = "Error fetching location.";
                            });
                    }
                );
            } else {
                locationDisplay.textContent = "Geolocation is not supported by this browser.";
            }
        });
    </script>
</body>
</html>
