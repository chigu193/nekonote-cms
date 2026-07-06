<?php
require_once '../functions.php';
require_once 'security_check.php';

// セキュリティチェック実行
adminSecurityCheck();

// ログインチェック
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// 削除処理
if (isset($_POST['delete_id'])) {
    // CSRF保護
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($csrfToken)) {
        die('不正なリクエストです。');
    }

    $deleteId = $_POST['delete_id'];
    $newsToDelete = getNewsById($deleteId);

    if ($newsToDelete) {
        if ($newsToDelete['image']) {
            deleteImage($newsToDelete['image']);
        }

        $allNews = loadNews();
        $allNews = array_filter($allNews, function ($item) use ($deleteId) {
            return $item['id'] !== $deleteId;
        });

        saveNews(array_values($allNews));
        header('Location: dashboard.php');
        exit();
    }
}

$news = loadNews();
usort($news, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - ダッシュボード</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header class="header">
    <h1>CMS管理画面</h1>
    <div>
        <span>ようこそ、<?php echo htmlspecialchars($_SESSION['admin_username']); ?>さん</span>
        <a href="logout.php" class="logout-btn">ログアウト</a>
    </div>
</header>

<body class="dashboard-body">
    <div class="container">

        <div class="actions">
            <a href="create.php" class="btn btn-success">新しいお知らせを作成</a>
            <a href="/news/" class="btn" target="_blank">お知らせ一覧を見る</a>
            <a href="change_password.php" class="btn btn-secondary">🔒 パスワード変更</a>
        </div>

        <div class="news-table">
            <h2>お知らせ管理 (<?php echo count($news); ?>件)</h2>

            <?php if (count($news) > 0): ?>
                <div class="maintenance-notice">
                    💡 <strong>定期メンテナンスのお願い</strong><br>
                    サイトの表示速度を保つため、古くなったお知らせは定期的に削除することをお勧めします。
                </div>
            <?php endif; ?>

            <?php if (empty($news)): ?>
                <div class="empty-state">
                    <h3>お知らせがありません</h3>
                    <p>新しいお知らせを作成してください</p>
                </div>
            <?php else: ?>
                <?php foreach ($news as $item): ?>
                    <div class="news-item">
                        <div class="news-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="news-meta">
                            投稿日時: <?php echo date('Y年m月d日 H:i', strtotime($item['created_at'])); ?>
                            <?php if ($item['image']): ?>
                                | <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="画像" class="dashboard-thumb">
                            <?php endif; ?>
                        </div>
                        <div style="color: #666; margin: 10px 0;">
                            <?php echo nl2br(htmlspecialchars(mb_substr($item['content'], 0, 100))); ?>
                            <?php if (mb_strlen($item['content']) > 100): ?>...<?php endif; ?>
                        </div>
                        <div class="news-actions">
                            <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn btn-small">編集</a>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('⚠️ この記事を完全に削除します。\n\n「<?php echo addslashes(mb_substr($item['title'], 0, 30)); ?><?php echo mb_strlen($item['title']) > 30 ? '...' : ''; ?>」\n\n本当に削除してよろしいですか？\n※この操作は取り消せません。');">
                                <?php echo csrfTokenField(); ?>
                                <input type="hidden" name="delete_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn-small btn-danger"> 削除</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>