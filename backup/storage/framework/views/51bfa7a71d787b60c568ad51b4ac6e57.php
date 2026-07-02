<!DOCTYPE html>
<html>
<head>
    <title>Halaman Landing Page Makanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f8f8;
        }

        .food-image {
            max-width: 500px;
            animation: rotate 5s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .text {
            text-align: center;
            margin-top: 50px;
        }

        .text h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .text p {
            font-size: 18px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="food-image" src="path_to_food_image.png" alt="Food Image">
    </div>

    <div class="text">
        <h1>Selamat Datang di Restoran XYZ</h1>
        <p>Nikmati berbagai hidangan lezat kami!</p>
    </div>

    <script>
        // Tambahkan skrip JavaScript tambahan di sini (jika diperlukan)
    </script>
</body>
</html>
<?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views/welcome.blade.php ENDPATH**/ ?>