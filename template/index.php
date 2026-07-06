<?php
if (!function_exists('getLatestNews')) {
  require_once __DIR__ . '/cms/functions.php';
}
include('head.php');
?>

<body>
  <?php include('header.php'); ?>
  <main>
  <section class="un_homeMv_inner">
    <h2 class="un_homeMv_ttl">猫の手CMS</h2>
    <p class="un_homeMv_txt">ちょっと手伝うにゃ〜</p>
  </section>

  <section class="ly_wrap">
    <div class="ly_contLg">
    <h2 class="el_lgHeading fade-in">お知らせ</h2>
    <p class="el_lgHeading_en">news</p>
    <!-- お知らせの件数設定 -->
    <?php $latestNews = getLatestNews(6); ?>
    <!-- お知らせセクション -->
    <?php if (!empty($latestNews)): ?>
    <section class="news-section">
      <div class="section-header">
      <h3>【sample】最新のお知らせ（リスト型）</h3>
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
          <button class="camera-btn" onclick="openImageModal('<?php echo htmlspecialchars($item['image']); ?>', '<?php echo htmlspecialchars($item['title']); ?>')">📷</button>
          <?php endif; ?>
        </div>
        </div>
        <div class="news-item-excerpt">
        <?php $fullContent = strip_tags($item['content']);
            $excerpt = mb_substr($fullContent, 0, 100);
            $isTruncated = mb_strlen($fullContent) > 100; ?>
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
    </div>
  </section>

  <section class="ly_wrap">
    <div class="ly_contLg">
     <!-- お知らせの件数設定 -->
    <?php $latestNews = getLatestNews(6); ?>
    <!-- カード型お知らせセクション -->
    <?php if (!empty($latestNews)): ?>
      <section class="news-cards-section">
        <div class="section-header">
          <h3>【sample】最新のお知らせ（カード型）</h3>
          <a href="/news/" class="view-all-link">すべて見る →</a>
        </div>
        <div class="news-cards-grid">
          <?php foreach ($latestNews as $item): ?>
            <article class="news-card">
              <?php if ($item['image']): ?>
                <div class="news-card-image">
                  <img src="/cms/uploads/<?php echo htmlspecialchars($item['image']); ?>"
                    alt="<?php echo htmlspecialchars($item['title']); ?>"
                    onclick="openImageModal('<?php echo htmlspecialchars($item['image']); ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
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
    </div>
  </section>
  </main>

  <?php include('footer.php'); ?>
</body>

</html>
