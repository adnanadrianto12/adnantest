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
            background: #2c003e;
            color: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            animation: fadeIn 1.5s ease-out forwards;
        }

        .card-header {
            position: relative;
            padding: 20px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 2em;
            margin: 0;
            animation: slideIn 1.5s ease-in-out forwards;
        }

        .card-content {
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
        }

        .card-content p {
            margin: 0;
            font-size: 1.2em;
        }

        .card-content button {
            margin-top: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background: #1db954;
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .card-content button:hover {
            background: #14833b;
            transform: scale(1.1);
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
        </div>
    </div>
</body>
</html>
