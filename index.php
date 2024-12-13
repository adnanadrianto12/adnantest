<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waduhhh</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a1b9a, #000);
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
            position: relative;
            z-index: 1;
        }

        h1 {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 3rem;
            font-weight: bold;
            margin: 0;
            z-index: 10; /* Pastikan elemen ini berada di atas */
            pointer-events: none; /* Agar tidak terganggu elemen iframe */
            opacity: 0;
            animation: fadeInMove 1.5s ease forwards;
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

        @keyframes fadeInMove {
            0% {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="spotify-container">
        <h1>Waduh</h1>
        <iframe 
            src="https://open.spotify.com/embed/track/1is8gU4RVcN4J8xItxWoOY?utm_source=generator" 
            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
            loading="lazy">
        </iframe>
    </div>
</body>
</html>
