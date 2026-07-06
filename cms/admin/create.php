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
    // CSRF保護
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($csrfToken)) {
        $error = '不正なリクエストです。';
    } else {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $publishDate = trim($_POST['publish_date'] ?? '');

        if (empty($title)) {
            $error = 'タイトルは必須です';
        } elseif (empty($content)) {
            $error = 'コンテンツは必須です';
        } elseif (empty($publishDate)) {
            $error = '投稿日時は必須です';
        } else {
            $newsItem = [
                'id' => generateId(),
                'title' => $title,
                'content' => $content,
                'image' => null,
                'created_at' => $publishDate . ':00',
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // 画像のアップロード処理
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = uploadImage($_FILES['image']);
                if ($uploadedFile) {
                    $newsItem['image'] = $uploadedFile;
                } else {
                    $error = '画像のアップロードに失敗しました';
                }
            }

            if (!$error) {
                $news = loadNews();
                $news[] = $newsItem;

                if (saveNews($news)) {
                    $success = 'お知らせを作成しました';
                    $_POST = [];
                } else {
                    $error = 'データの保存に失敗しました';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせ作成 - CMS</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="create-page-body">
    <header class="header">
        <div class="header-content">
            <h1>新しいお知らせを作成</h1>
            <a href="dashboard.php" class="back-link">← ダッシュボードに戻る</a>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>お知らせを作成</h2>
                <p>お知らせの内容を作成してください</p>
            </div>


            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <?php echo csrfTokenField(); ?>
                <div class="form-group">
                    <label for="title">タイトル *</label>
                    <input type="text" id="title" name="title" required
                        value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="content">コンテンツ *</label>
                    <textarea id="content" name="content" required
                        placeholder="お知らせの内容を入力してください"><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="publish_date">投稿日時 *</label>
                    <input type="datetime-local" id="publish_date" name="publish_date" required
                        value="<?php echo htmlspecialchars($_POST['publish_date'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="image">画像（オプション）</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*"
                            onchange="previewImage(this)">
                        <div class="file-input-content">
                            <strong>クリックして画像を選択</strong><br>
                            または画像をドラッグ&ドロップ<br>
                            <small>対応形式: JPG, PNG, GIF</small>
                        </div>
                    </div>
                    <div id="imagePreview" class="image-preview"></div>
                </div>

                <div class="form-actions">
                    <a href="dashboard.php" class="btn btn-secondary">キャンセル</a>
                    <button type="submit" class="btn btn-primary">作成する</button>
                </div>
            </form>

        </div>
    </div>
    <script>
        // 現在時刻を設定
        document.addEventListener('DOMContentLoaded', function() {
            const publishDateInput = document.getElementById('publish_date');
            if (!publishDateInput.value) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                publishDateInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        });

        // 画像プレビュー機能
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);

                    // ファイル名も表示
                    const fileName = document.createElement('p');
                    fileName.textContent = '選択された画像: ' + input.files[0].name;
                    fileName.style.marginTop = '10px';
                    fileName.style.color = '#666';
                    fileName.style.fontSize = '0.9rem';
                    preview.appendChild(fileName);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>