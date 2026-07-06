<?php
// セキュリティ設定

// 管理画面アクセス許可IP（あなたのIPアドレスを設定）
// 複数のIPを許可する場合は配列に追加
$ALLOWED_IPS = [
    '127.0.0.1',        // ローカルホスト
    '::1',              // IPv6ローカルホスト
    '192.168.0.222',  // あなたのローカルIP（例）
    // '123.456.789.012' // あなたのグローバルIP（例）
];

// セッションセキュリティ設定
$SESSION_TIMEOUT = 3600; // 1時間でタイムアウト
$SESSION_REGENERATE_INTERVAL = 300; // 5分ごとにセッションID再生成

// ログイン試行制限
$MAX_LOGIN_ATTEMPTS = 5;
$LOGIN_BLOCK_TIME = 900; // 15分間ブロック

// ファイルアップロード制限
$MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
$ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
$ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];

// セキュリティヘッダー
function setSecurityHeaders()
{
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // HSTS: HTTPS環境でのみ有効化（1年間ブラウザに記憶させる）
    if (isset($_SERVER['HTTPS'])) {
        header('Strict-Transport-Security: max-age=31536000');
    }
}

// IP制限チェック
function checkIPAccess($allowedIPs)
{
    $userIP = $_SERVER['REMOTE_ADDR'] ?? '';

    // プロキシ経由の場合の実際のIPを取得
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $userIP = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $userIP = $_SERVER['HTTP_X_REAL_IP'];
    }

    $userIP = trim($userIP);

    if (!in_array($userIP, $allowedIPs)) {
        http_response_code(403);
        die('Access denied. Your IP (' . htmlspecialchars($userIP) . ') is not authorized.');
    }
}
