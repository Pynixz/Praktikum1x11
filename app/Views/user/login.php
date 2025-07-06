<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
    <style>
        /* Login Page Specific Styles */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert {
            position: relative;
        }

        .close-btn:hover {
            opacity: 1 !important;
        }

        .login-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .login-footer p {
            color: #666;
            font-size: 12px;
            margin: 0;
        }

        .demo-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #495057;
        }

        .demo-info strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p>Silakan masuk untuk mengakses panel admin</p>
        </div>

        <!-- Demo Credentials Info -->
        <div class="demo-info">
            <strong>Demo Login:</strong><br>
            Email: admin@email.com<br>
            Password: admin123
        </div>

        <?php if (session()->getFlashdata('flash_msg')): ?>
            <?php
            $message = session()->getFlashdata('flash_msg');
            $isLogoutMessage = (strpos($message, 'logout') !== false);
            $alertClass = $isLogoutMessage ? 'alert-success' : 'alert-danger';
            ?>
            <div class="alert <?= $alertClass ?>" id="loginFlashMessage">
                <span class="close-btn" onclick="closeLoginFlashMessage()" style="position: absolute; top: 8px; right: 12px; cursor: pointer; font-size: 18px; opacity: 0.7;">&times;</span>
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="InputForEmail">Email Address</label>
                <input type="email" name="email" class="form-control" id="InputForEmail"
                       value="<?= set_value('email') ?>" placeholder="Masukkan email Anda" required>
            </div>

            <div class="form-group">
                <label for="InputForPassword">Password</label>
                <input type="password" name="password" class="form-control" id="InputForPassword"
                       placeholder="Masukkan password Anda" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="login-footer">
            <p>&copy; 2024 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Auto-close flash message after 3 seconds
        function closeLoginFlashMessage() {
            const flashMessage = document.getElementById('loginFlashMessage');
            if (flashMessage) {
                flashMessage.style.transition = 'all 0.5s ease-out';
                flashMessage.style.opacity = '0';
                flashMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    flashMessage.style.display = 'none';
                }, 500);
            }
        }

        // Auto-close after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('loginFlashMessage');
            if (flashMessage) {
                setTimeout(() => {
                    closeLoginFlashMessage();
                }, 3000); // 3 seconds
            }
        });
    </script>
</body>
</html>
