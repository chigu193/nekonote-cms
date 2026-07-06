<?php
require_once '../functions.php';

// ログインチェック
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$newsItem = null;

// IDの取得
$id = $_GET['id'] ?? '';
if (empty($id)) {
    header('Location: dashboard.php');
    exit();
}

// お知らせの取得
$newsItem = getNewsById($id);
if (!$newsItem) {
    header('Location: dashboard.php');
    exit();
}

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
            $news = loadNews();
            $foundIndex = -1;
            
            // 該当のお知らせを探す
            foreach ($news as $index => $item) {
                if ($item['id'] === $id) {
                    $foundIndex = $index;
                    break;
                }
            }
            
            if ($foundIndex !== -1) {
                // 更新データの準備
                $news[$foundIndex]['title'] = $title;
                $news[$foundIndex]['content'] = $content;
                $news[$foundIndex]['created_at'] = $publishDate . ':00'; // 投稿日時を更新
                $news[$foundIndex]['updated_at'] = date('Y-m-d H:i:s');
                
                // 新しい画像がアップロードされた場合
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    // 古い画像を削除
                    if ($news[$foundIndex]['image']) {
                        deleteImage($news[$foundIndex]['image']);
                    }
                    
                    $uploadedFile = uploadImage($_FILES['image']);
                    if ($uploadedFile) {
                        $news[$foundIndex]['image'] = $uploadedFile;
                    } else {
                        $error = '画像のアップロードに失敗しました';
                    }
                }
                
                // 画像削除の処理
                if (isset($_POST['remove_image']) && $_POST['remove_image'] === '1') {
                    if ($news[$foundIndex]['image']) {
                        deleteImage($news[$foundIndex]['image']);
                        $news[$foundIndex]['image'] = null;
                    }
                }
                
                if (!$error) {
                    if (saveNews($news)) {
                        $success = 'お知らせを更新しました';
                        $newsItem = $news[$foundIndex]; // 更新されたデータを反映
                    } else {
                        $error = 'データの保存に失敗しました';
                    }
                }
            } else {
                $error = 'お知らせが見つかりません';
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
    <title>お知らせ編集 - CMS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="edit-page-body">
    <header class="header">
        <div class="header-content">
            <h1>お知らせ編集</h1>
            <a href="dashboard.php" class="back-link">← ダッシュボードに戻る</a>
        </div>
    </header>
    
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>お知らせを編集</h2>
                <p>お知らせの内容を変更してください</p>
            </div>
            
            <div class="meta-info">
                <strong>作成日時:</strong> <?php echo date('Y年m月d日 H:i', strtotime($newsItem['created_at'])); ?><br>
                <?php if ($newsItem['updated_at'] !== $newsItem['created_at']): ?>
                    <strong>最終更新:</strong> <?php echo date('Y年m月d日 H:i', strtotime($newsItem['updated_at'])); ?>
                <?php endif; ?>
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
                           value="<?php echo htmlspecialchars($_POST['title'] ?? $newsItem['title']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="content">コンテンツ *</label>
                    <textarea id="content" name="content" required 
                              placeholder="お知らせの内容を入力してください"><?php echo htmlspecialchars($_POST['content'] ?? $newsItem['content']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="publish_date">投稿日時 *</label>
                    <?php 
                    // 現在の投稿日時をdatetime-local形式に変換
                    $currentDateTime = $_POST['publish_date'] ?? date('Y-m-d\TH:i', strtotime($newsItem['created_at']));
                    ?>
                    <input type="datetime-local" id="publish_date" name="publish_date" required 
                           value="<?php echo htmlspecialchars($currentDateTime); ?>">
                    <small class="form-help">投稿日時を変更できます（未来の日時も設定可能）</small>
                </div>
                
                <div class="form-group">
                    <label for="image">画像</label>
                    
                    <?php if ($newsItem['image']): ?>
                        <div class="current-image">
                            <p><strong>現在の画像:</strong></p>
                            <img src="../uploads/<?php echo htmlspecialchars($newsItem['image']); ?>" 
                                 alt="現在の画像">
                            <div class="image-actions">
                                <button type="button" class="remove-image-btn" 
                                        onclick="removeCurrentImage()">現在の画像を削除</button>
                            </div>
                        </div>
                        <input type="hidden" id="removeImageFlag" name="remove_image" value="0">
                    <?php endif; ?>
                    
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*" 
                               onchange="previewImage(this)">
                        <div class="file-input-content">
                            <strong><?php echo $newsItem['image'] ? '新しい画像を選択' : 'クリックして画像を選択'; ?></strong><br>
                            または画像をドラッグ&ドロップ<br>
                            <small>対応形式: JPG, PNG, GIF</small>
                        </div>
                    </div>
                    <div id="imagePreview" class="image-preview"></div>
                </div>
                
                <div class="form-actions">
                    <a href="dashboard.php" class="btn btn-secondary">キャンセル</a>
                    <button type="submit" class="btn btn-primary">更新する</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function removeCurrentImage() {
            if (confirm('現在の画像を削除しますか？')) {
                document.getElementById('removeImageFlag').value = '1';
                document.querySelector('.current-image').style.opacity = '0.5';
                document.querySelector('.remove-image-btn').textContent = '削除予定';
                document.querySelector('.remove-image-btn').disabled = true;
            }
        }
    </script>
</body>
</html>