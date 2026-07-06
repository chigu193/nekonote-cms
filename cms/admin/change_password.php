<?php
require_once '../functions.php';

// ログインチェック
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_POST) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword)) {
        $error = '現在のパスワードを入力してください';
    } elseif (empty($newPassword)) {
        $error = '新しいパスワードを入力してください';
    } elseif (strlen($newPassword) < 8) {
        $error = '新しいパスワードは8文字以上で入力してください';
    } elseif ($newPassword !== $confirmPassword) {
        $error = '新しいパスワードと確認用パスワードが一致しません';
    } elseif (!validateUser($_SESSION['admin_username'], $currentPassword)) {
        $error = '現在のパスワードが間違っています';
    } else {
        // パスワード変更処理
        if (changePassword($_SESSION['admin_username'], $newPassword)) {
            $success = 'パスワードを変更しました';
        } else {
            $error = 'パスワードの変更に失敗しました';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード変更 - CMS</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>

<body class="create-page-body">
    <header class="header">
        <div class="header-content">
            <h1>パスワード変更</h1>
            <a href="dashboard.php" class="back-link">← ダッシュボードに戻る</a>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>パスワードを変更</h2>
                <p>セキュリティのため定期的にパスワードを変更することをお勧めします</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="current_password">現在のパスワード *</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">新しいパスワード *</label>
                    <input type="password" id="new_password" name="new_password" required
                        minlength="8" placeholder="8文字以上">
                    <small class="form-help">セキュリティのため8文字以上で設定してください</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">新しいパスワード（確認用）*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-actions">
                    <a href="dashboard.php" class="btn btn-secondary">キャンセル</a>
                    <button type="submit" class="btn btn-primary">パスワードを変更</button>
                </div>
            </form>

            <div class="security-note">
                <h3>🔒 セキュリティのヒント</h3>
                <ul>
                    <li>英数字を組み合わせた複雑なパスワードを使用</li>
                    <li>他のサービスと同じパスワードは避ける</li>
                    <li>定期的にパスワードを変更する</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    .security-note {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
    }

    .security-note h3 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .security-note ul {
        color: #666;
        line-height: 1.6;
        margin: 0;
        padding-left: 20px;
    }

    .security-note li {
        margin-bottom: 8px;
    }
</style>
