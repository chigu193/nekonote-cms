<?php
// 管理画面用セキュリティチェック
require_once '../security_config.php';

// セキュリティヘッダーを設定
setSecurityHeaders();

// IPアクセス制限（無効 - 使いやすさ優先）
// checkIPAccess($ALLOWED_IPS);

// セッションセキュリティ
function secureSession() {
    global $SESSION_TIMEOUT, $SESSION_REGENERATE_INTERVAL;
    
    // セッションタイムアウトチェック
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity']) > $SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header('Location: login.php?timeout=1');
        exit();
    }
    
    $_SESSION['last_activity'] = time();
    
    // セッションID再生成
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif ((time() - $_SESSION['last_regeneration']) > $SESSION_REGENERATE_INTERVAL) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// 管理画面アクセス時の共通チェック
function adminSecurityCheck() {
    secureSession();
}
?>