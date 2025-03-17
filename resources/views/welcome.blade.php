<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeriGasy</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            overflow: hidden;
        }
        .welcome-message {
            font-size: 2.5em;
            opacity: 0;
            transform: scale(0.5);
            animation: fadeInScale 2s ease-out forwards;
        }
        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: floatUp 6s infinite ease-in-out;
        }
        @keyframes floatUp {
            0% {
                transform: translateY(100vh) scale(0.5);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) scale(1.2);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-message">Bienvenue sur notre NumeriGasy !</div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            for (let i = 0; i < 15; i++) {
                let bubble = document.createElement("div");
                bubble.classList.add("bubble");
                let size = Math.random() * 50 + 10;
                bubble.style.width = size + "px";
                bubble.style.height = size + "px";
                bubble.style.left = Math.random() * 100 + "vw";
                bubble.style.animationDuration = (Math.random() * 3 + 3) + "s";
                document.body.appendChild(bubble);
            }
        });
    </script>
</body>
</html>
