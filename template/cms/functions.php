<?php
// セッション設定
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);  // HTTPS時は自動で有効化
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

session_start();

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function loadNews() {
    $file = __DIR__ . '/data/news.json';
    if (file_exists($file)) {
        $content = file_get_contents($file);
        return json_decode($content, true) ?: [];
    }
    return [];
}

function saveNews($news) {
    $file = __DIR__ . '/data/news.json';
    return file_put_contents($file, json_encode($news, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function generateId() {
    return uniqid();
}

function uploadImage($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }
    
    $filename = generateId() . '.jpg'; // 常にJPEGで保存
    $uploadPath = __DIR__ . '/uploads/' . $filename;
    
    // 画像の最適化処理
    if (optimizeAndSaveImage($file['tmp_name'], $uploadPath, $file['type'])) {
        return $filename;
    }
    
    return false;
}

function optimizeAndSaveImage($sourcePath, $destinationPath, $mimeType) {
    // 設定値
    $maxWidth = 800;  // 最大幅
    $maxHeight = 600; // 最大高さ
    $quality = 80;    // JPEG品質 (0-100)
    
    // 元画像の情報を取得
    $imageInfo = getimagesize($sourcePath);
    if ($imageInfo === false) {
        return false;
    }
    
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];
    
    // リサイズが必要かチェック
    $needResize = ($originalWidth > $maxWidth || $originalHeight > $maxHeight);
    
    if ($needResize) {
        // リサイズ比率を計算
        $ratioW = $maxWidth / $originalWidth;
        $ratioH = $maxHeight / $originalHeight;
        $ratio = min($ratioW, $ratioH);
        
        $newWidth = (int)($originalWidth * $ratio);
        $newHeight = (int)($originalHeight * $ratio);
    } else {
        $newWidth = $originalWidth;
        $newHeight = $originalHeight;
    }
    
    // 元画像を読み込み
    switch ($mimeType) {
        case 'image/jpeg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }
    
    if ($sourceImage === false) {
        return false;
    }
    
    // 新しい画像を作成
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // 透明度を保持（PNG/GIF用）
    if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefill($newImage, 0, 0, $transparent);
    }
    
    // 画像をリサイズ
    imagecopyresampled(
        $newImage, $sourceImage,
        0, 0, 0, 0,
        $newWidth, $newHeight,
        $originalWidth, $originalHeight
    );
    
    // JPEGで保存（常に）
    $result = imagejpeg($newImage, $destinationPath, $quality);
    
    // メモリを解放
    imagedestroy($sourceImage);
    imagedestroy($newImage);
    
    return $result;
}

function deleteImage($filename) {
    return safeDeleteImage($filename);
}

function getLatestNews($limit = 5) {
    $news = loadNews();
    usort($news, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    return array_slice($news, 0, $limit);
}

function getNewsById($id) {
    $news = loadNews();
    foreach ($news as $item) {
        if ($item['id'] === $id) {
            return $item;
        }
    }
    return null;
}

function validateUser($username, $password) {
    $file = __DIR__ . '/data/users.json';
    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);
        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                return true;
            }
        }
    }
    return false;
}

function validateDateTime($dateTime) {
    // datetime-local形式（YYYY-MM-DDTHH:MM）をチェック
    if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $dateTime)) {
        $date = DateTime::createFromFormat('Y-m-d\TH:i', $dateTime);
        return $date && $date->format('Y-m-d\TH:i') === $dateTime;
    }
    return false;
}

// パスワード変更機能
function changePassword($username, $newPassword) {
    $file = __DIR__ . '/data/users.json';
    if (!file_exists($file)) {
        return false;
    }
    
    $users = json_decode(file_get_contents($file), true);
    if (!$users) {
        return false;
    }
    
    // 該当ユーザーを探して更新
    foreach ($users as &$user) {
        if ($user['username'] === $username) {
            $user['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // ファイルに保存
            $result = file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $result !== false;
        }
    }
    
    return false;
}

// 新しいユーザーの追加機能
function addUser($username, $password) {
    $file = __DIR__ . '/data/users.json';
    
    // 既存ユーザーをロード
    $users = [];
    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true) ?: [];
    }
    
    // 同じユーザー名が存在するかチェック
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return false; // 既に存在
        }
    }
    
    // 新しいユーザーを追加
    $users[] = [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    
    // ファイルに保存
    $result = file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $result !== false;
}

// シンプルで動作するCSRF保護
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function csrfTokenField() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

// ログイン試行制限
function isLoginBlocked($ip) {
    $lockFile = __DIR__ . '/data/login_attempts.json';
    if (!file_exists($lockFile)) {
        return false;
    }
    
    $attempts = json_decode(file_get_contents($lockFile), true) ?: [];
    $attempts = array_filter($attempts, function($attempt) {
        return $attempt['time'] > time() - 900; // 15分でリセット
    });
    
    $ipAttempts = array_filter($attempts, function($attempt) use ($ip) {
        return $attempt['ip'] === $ip;
    });
    
    return count($ipAttempts) >= 5; // 5回失敗でブロック
}

function recordLoginAttempt($ip, $success = false) {
    $lockFile = __DIR__ . '/data/login_attempts.json';
    $attempts = [];
    
    if (file_exists($lockFile)) {
        $attempts = json_decode(file_get_contents($lockFile), true) ?: [];
    }
    
    if ($success) {
        // 成功時は該当IPの試行記録をクリア
        $attempts = array_filter($attempts, function($attempt) use ($ip) {
            return $attempt['ip'] !== $ip;
        });
    } else {
        // 失敗時は記録追加
        $attempts[] = [
            'ip' => $ip,
            'time' => time()
        ];
    }
    
    // 15分以上古い記録は削除
    $attempts = array_filter($attempts, function($attempt) {
        return $attempt['time'] > time() - 900;
    });
    
    file_put_contents($lockFile, json_encode(array_values($attempts)));
}

// 安全なファイル削除（パストラバーサル対策）
function safeDeleteImage($filename) {
    // ファイル名のサニタイズ
    $filename = basename($filename);
    if (empty($filename) || $filename === '.' || $filename === '..') {
        return false;
    }
    
    $uploadDir = __DIR__ . '/uploads/';
    $filePath = $uploadDir . $filename;
    
    // アップロードディレクトリ内かチェック
    if (strpos(realpath($filePath), realpath($uploadDir)) !== 0) {
        return false;
    }
    
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    
    return false;
}
?>