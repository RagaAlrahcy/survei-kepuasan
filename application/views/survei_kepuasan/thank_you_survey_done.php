<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('public/assets/favicon/favicon-lam-kprs.png') ?>">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --border-radius: 16px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f6f9fc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5;
            background-image: radial-gradient(#667eea 0.5px, #f6f9fc 0.5px);
            background-size: 10px 10px;
        }

        .thank-you-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.02);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            background: rgba(40, 167, 69, 0.1);
            /* Greenish background */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: #28a745;
            font-size: 3rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(40, 167, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }

        .title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .message {
            color: #718096;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0.05;
        }

        .circle-1 {
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
        }

        .circle-2 {
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>

    <div class="bg-pattern"></div>

    <div class="thank-you-card">
        <div class="decorative-circle circle-1"></div>
        <div class="decorative-circle circle-2"></div>

        <div class="icon-wrapper">
            <i class="bi bi-check-circle-fill"></i>
        </div>

        <h1 class="title">Terima Kasih</h1>

        <p class="message">
            Terimakasih Anda Sudah Mengisikan Ulasan Kuisioner.
        </p>

    </div>

</body>

</html>