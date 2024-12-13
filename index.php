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
            background: linear-gradient(to bottom, #6a1b9a, #000);
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .card {
            position: relative;
            width: 400px;
            border-radius: 16px;
            background: rgba(44, 0, 62, 0.9);
            color: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            animation: fadeIn 1.5s ease-out forwards;
        }

        .card-header {
            text-align: center;
            padding: 20px;
        }

        .card-header h1 {
            font-size: 2em;
            margin: 0;
            animation: slideIn 1.5s ease-in-out forwards;
        }

        .card-content {
            padding: 20px;
        }

        .spotify-iframe {
            margin-top: 20px;
            border-radius: 12px;
            width: 100%;
            height: 352px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>Waduh</h1>
        </div>
        <div class="card-content">
            <iframe 
                class="spotify-iframe" 
                src="https://open.spotify.com/embed/track/1is8gU4RVcN4J8xItxWoOY?utm_source=generator" 
                allowfullscreen="" 
                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</body>
</html>
