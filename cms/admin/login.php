<?php
require_once '../functions.php';

$error = '';

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (validateUser($username, $password)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['last_activity'] = time(); // セッションタイムアウト対策

        // セッション保存を強制
        session_write_close();
        session_start();

        // 直接リダイレクト
        header('Location: /cms/admin/dashboard.php');
        exit();
    } else {
        $error = 'ユーザー名またはパスワードが間違っています';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 40px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .demo-info {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }

        .demo-info code {
            background: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            color: #e74c3c;
            font-weight: bold;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #f44336;
        }

        .alert-success {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4caf50;
        }

        .back-to-top {
            text-align: center;
            margin-top: 20px;
        }

        .btn-back-home {
            display: inline-block;
            background: #95a5a6;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }

        .btn-back-home:hover {
            background: #7f8c8d;
        }

        .cms-footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .cms-footer p {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .cms-footer small {
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>管理者ログイン</h1>
            <p>CMSシステムにログインしてください</p>
        </div>

        <?php if ($error): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['logout'])): ?>
            <div class="alert-success">✅ ログアウトしました</div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">ユーザー名</label>
                <input type="text" id="username" name="username" value="admin" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" placeholder="password" required>
            </div>

            <button type="submit" class="btn" style="width: 100%;">ログイン</button>
        </form>

        <div class="back-to-top">
            <a href="/" class="btn-back-home">🏠 トップページに戻る</a>
        </div>

        <div class="cms-footer">
            <p>🐱 猫の手CMS v1.0</p>
            <small>Simple & Secure Content Management System</small>
        </div>
    </div>
</body>

</html>