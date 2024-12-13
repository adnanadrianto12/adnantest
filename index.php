<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Embed</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1DB954, #191414);
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .spotify-container {
            position: relative;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            overflow: hidden;
            transform: scale(0.8);
            animation: zoomIn 1s ease forwards;
        }

        .spotify-container:hover {
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        iframe {
            border-radius: 12px;
            width: 100%;
            height: 352px;
            border: none;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="spotify-container">
        <iframe 
            src="https://open.spotify.com/embed/track/1is8gU4RVcN4J8xItxWoOY?utm_source=generator" 
            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
            loading="lazy">
        </iframe>
    </div>
</body>
</html>
