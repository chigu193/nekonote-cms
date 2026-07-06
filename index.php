<?php
$page_title = "ホーム - My Website";
require_once __DIR__ . '/cms/functions.php';
include 'head.php';
?>

<body>
  <?php include 'header.php'; ?>

  <section class="hero">
    <div class="hero-background"></div>
    <div class="hero-content">
      <div class="hero-text-content">
        <h1>猫の手CMS</h1>
        <p class="hero-text">ちょっと助けてくれる<br>便利なお知らせ簡易CMSでシンプル更新</p>
        <div class="hero-buttons">
          <a href="/about/" class="btn">詳しく見る</a>
          <a href="/cms/admin/login.php/" class="btn btn-admin">管理者ログイン</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&h=400&fit=crop&auto=format"
          alt="可愛い猫" loading="lazy">
      </div>
    </div>
  </section>
  <main>
    <section class="cms-features">
      <div class="features-header">
        <h2>猫の手CMS機能</h2>
        <p>お知らせ特化更新システムのミニマムな軽量CMSを搭載しています</p>
      </div>

      <div class="content-grid">
        <div class="card">
          <h3>📝 投稿管理</h3>
          <p>タイトル、コンテンツ、投稿日時を自由に設定してお知らせを作成・編集できます。</p>
        </div>
        <div class="card">
          <h3>🖼️ 画像アップロード</h3>
          <p>1記事につき1枚の画像を添付可能。画像はクリックで拡大表示されます。</p>
        </div>
        <div class="card">
          <h3>💾 シンプル管理</h3>
          <p>データベース不要でJSONファイルで管理。シンプルで軽量なシステムです。</p>
        </div>
      </div>

      <div class="cms-actions">
        <a href="/about/" class="btn">使い方ガイド</a>
        <a href="/news/" class="btn">お知らせ一覧</a>
      </div>
    </section>
    <!-- お知らせの件数設定 -->
    <?php $latestNews = getLatestNews(6); ?>
    <!-- お知らせセクション -->
    <?php if (!empty($latestNews)): ?>
      <section class="news-section">
        <div class="section-header">
          <h2>【sample】最新のお知らせ</h2>
          <a href="/news/" class="view-all-link">すべて見る →</a>
        </div>
        <div class="news-list">
          <?php foreach ($latestNews as $item): ?>
            <article class="news-item">
              <div class="news-item-header">
                <h3 class="news-item-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                <div class="news-item-meta">
                  <span class="news-item-date"><?php echo date('Y年m月d日', strtotime($item['created_at'])); ?></span>
                  <?php if ($item['image']): ?>
                    <button class="camera-btn" onclick="openImageModal('<?php echo htmlspecialchars($item['image'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['title'], ENT_QUOTES); ?>')">
                      📷
                    </button>
                  <?php endif; ?>
                </div>
              </div>
              <div class="news-item-excerpt">
                <?php
                $fullContent = strip_tags($item['content']);
                $excerpt = mb_substr($fullContent, 0, 100);
                $isTruncated = mb_strlen($fullContent) > 100;
                ?>
                <p class="excerpt-text" data-full="<?php echo htmlspecialchars($fullContent); ?>" data-excerpt="<?php echo htmlspecialchars($excerpt) . ($isTruncated ? '...' : ''); ?>"><?php echo htmlspecialchars($excerpt) . ($isTruncated ? '...' : ''); ?></p>
                <?php if ($isTruncated): ?>
                  <button class="toggle-text-btn" onclick="toggleFullText(this)">全文表示</button>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- 画像モーダル -->
    <div id="imageModal" class="modal" onclick="closeImageModal()">
      <div class="modal-content">
        <span class="close" onclick="closeImageModal()">&times;</span>
        <img id="modalImage" src="" alt="">
        <div id="modalCaption"></div>
      </div>
    </div>


    <!-- お知らせの件数設定 -->
    <?php $latestNews = getLatestNews(6); ?>
    <!-- カード型お知らせセクション -->
    <?php if (!empty($latestNews)): ?>
      <section class="news-cards-section">
        <div class="section-header">
          <h2>【sample】最新のお知らせ（カード型）</h2>
          <a href="/news/" class="view-all-link">すべて見る →</a>
        </div>
        <div class="news-cards-grid">
          <?php foreach ($latestNews as $item): ?>
            <article class="news-card">
              <?php if ($item['image']): ?>
                <div class="news-card-image">
                  <img src="/cms/uploads/<?php echo htmlspecialchars($item['image']); ?>"
                    alt="<?php echo htmlspecialchars($item['title']); ?>"
                    onclick="openImageModal('<?php echo htmlspecialchars($item['image'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['title'], ENT_QUOTES); ?>')">
                </div>
              <?php endif; ?>
              <div class="news-card-content">
                <div class="news-card-meta">
                  <span class="news-card-date"><?php echo date('Y年m月d日', strtotime($item['created_at'])); ?></span>
                </div>
                <h3 class="news-card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                <div class="news-card-excerpt">
                  <?php
                  $fullContent = strip_tags($item['content']);
                  $excerpt = mb_substr($fullContent, 0, 80);
                  $isTruncated = mb_strlen($fullContent) > 80;
                  ?>
                  <p class="excerpt-text" data-full="<?php echo htmlspecialchars($fullContent); ?>" data-excerpt="<?php echo htmlspecialchars($excerpt) . ($isTruncated ? '...' : ''); ?>"><?php echo htmlspecialchars($excerpt) . ($isTruncated ? '...' : ''); ?></p>
                  <?php if ($isTruncated): ?>
                    <button class="toggle-text-btn" onclick="toggleFullText(this)">全文表示</button>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- 画像モーダル -->
    <div id="imageModal" class="modal" onclick="closeImageModal()">
      <div class="modal-content">
        <span class="close" onclick="closeImageModal()">&times;</span>
        <img id="modalImage" src="" alt="">
        <div id="modalCaption"></div>
      </div>
    </div>




    <link rel="stylesheet" href="/cms/frontend.css">

    <style>
      .hero {
        position: relative;
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        overflow: hidden;
        min-height: 500px;
        display: flex;
        align-items: center;
      }

      .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        z-index: 1;
      }

      .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 60px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .hero-text-content {
        flex: 1;
        text-align: left;
      }

      .hero-image {
        flex: 0 0 400px;
        text-align: center;
      }

      .hero-image img {
        width: 100%;
        max-width: 400px;
        height: 300px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
      }

      .hero-image img:hover {
        transform: translateY(-5px);
      }

      .hero h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        font-weight: 300;
      }

      .hero-text {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
      }

      .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
      }

      .btn {
        display: inline-block;
        background-color: #3498db;
        color: white;
        padding: 12px 30px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 500;
        transition: background-color 0.3s ease;
      }

      .btn:hover {
        background-color: #2980b9;
      }

      .btn-admin {
        background-color: #e74c3c;
      }

      .btn-admin:hover {
        background-color: #c0392b;
      }

      .cms-features {
        padding: 60px 0;
        background: #f8f9fa;
        margin: 40px -20px;
      }

      .features-header {
        text-align: center;
        margin-bottom: 50px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        padding: 0 20px;
      }

      .features-header h2 {
        color: #2c3e50;
        font-size: 2.2rem;
        font-weight: 300;
        margin-bottom: 15px;
      }

      .features-header p {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.6;
      }

      .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto 40px;
        padding: 0 20px;
      }

      .cms-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        padding: 0 20px;
      }

      .card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }

      .card:hover {
        transform: translateY(-5px);
      }

      .card h3 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.3rem;
      }

      .card p {
        color: #666;
        line-height: 1.6;
      }

      /* レスポンシブ対応 */
      @media (max-width: 768px) {
        .hero {
          min-height: auto;
          padding: 60px 0;
        }

        .hero-content {
          flex-direction: column;
          gap: 40px;
          text-align: center;
        }

        .hero-text-content {
          text-align: center;
        }

        .hero-image {
          flex: none;
          width: 100%;
        }

        .hero-image img {
          max-width: 300px;
          height: 250px;
        }

        .hero h1 {
          font-size: 2.5rem;
        }
      }
    </style>

    <script src="/cms/frontend.js"></script>
  </main>

  <?php include 'footer.php'; ?>
</body>

</html>
