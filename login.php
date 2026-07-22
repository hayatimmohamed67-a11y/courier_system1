<?php
/**
 * login.php - Bogga Gelitaanka (Login Page) - Sage Green Theme (#ACBDAA)
 */
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username ama Password waa qalad!';
    }
}
?>
<!DOCTYPE html>
<html lang="so">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CourierPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2d3a2e, #4a5b4a, #2d3a2e);
            padding: 20px;
        }

        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.6);
        }

        /* ===== LEFT SIDE: IMAGE ===== */
        .login-image {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&h=800&fit=crop&q=80') no-repeat center center;
            background-size: cover;
            min-height: 500px;
            display: none;
            position: relative;
        }

        .login-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(45, 58, 46, 0.5), rgba(74, 91, 74, 0.3));
        }

        .login-image .image-text {
            position: absolute;
            bottom: 40px;
            left: 40px;
            z-index: 1;
            color: #fff;
        }

        .login-image .image-text h2 {
            font-size: 24px;
            font-weight: 700;
        }

        .login-image .image-text p {
            opacity: 0.8;
            font-size: 14px;
        }

        @media (min-width: 768px) {
            .login-image {
                display: block;
            }
        }

        /* ===== RIGHT SIDE: LOGIN FORM ===== */
        .login-card {
            flex: 1;
            padding: 48px 40px;
            min-width: 320px;
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo .icon-box {
            display: inline-block;
            background: rgba(172, 189, 170, 0.2);
            padding: 16px;
            border-radius: 20px;
            margin-bottom: 12px;
        }

        .logo .icon-box i {
            font-size: 40px;
            color: #ACBDAA;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .logo h1 span {
            color: #ACBDAA;
        }

        .logo p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within {
            border-color: #ACBDAA;
            background: rgba(172, 189, 170, 0.06);
            box-shadow: 0 0 0 4px rgba(172, 189, 170, 0.1);
        }

        .input-wrapper i {
            color: rgba(255, 255, 255, 0.3);
            padding: 0 16px;
            min-width: 48px;
        }

        .input-wrapper:focus-within i {
            color: #ACBDAA;
        }

        .input-wrapper input {
            width: 100%;
            padding: 16px 16px 16px 0;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
        }

        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .toggle-password {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            padding: 0 16px;
            font-size: 16px;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #8fa38d, #ACBDAA, #c5d4c3);
            border: none;
            border-radius: 14px;
            color: #1a2a1a;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Inter', sans-serif;
            margin-top: 4px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(172, 189, 170, 0.4);
        }

        .btn-login:active {
            transform: translateY(0px);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fca5a5;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .demo-credentials {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 12px 16px;
            margin-top: 16px;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
        }

        .demo-credentials strong {
            color: rgba(255, 255, 255, 0.5);
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            color: rgba(255, 255, 255, 0.25);
            font-size: 12px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #ACBDAA;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 32px 20px;
            }
            .logo h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Left Side: Image -->
    <div class="login-image">
        <div class="image-text">
            <h2>CourierPro</h2>
            <p>Maamulka baakidhaha oo dhammaystiran</p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="login-card">
        <div class="logo">
            <div class="icon-box">
                <i class="fas fa-box"></i>
            </div>
            <h1>Courier<span>Pro</span></h1>
            <p>Gel si aad u maareyso</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username"><i class="fas fa-user me-1"></i> Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Geli magacaaga" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock me-1"></i> Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Geli password-kaaga" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Gal
            </button>
        </form>

        <div class="demo-credentials">
            <i class="fas fa-info-circle me-1"></i>
            Username: <strong>admin</strong> | Password: <strong>admin123</strong>
        </div>

        <div class="footer">
            &copy; 2026 CourierPro &bull; <a href="#">Privacy</a> &bull; <a href="#">Terms</a>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.className = 'fas fa-eye-slash';
        } else {
            passwordInput.type = 'password';
            eyeIcon.className = 'fas fa-eye';
        }
    }
</script>

</body>
</html>