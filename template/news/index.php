<?php
$title = "お知らせ";
// $description = '';
require_once __DIR__ . '/../cms/functions.php';
include __DIR__ . '/../head.php';
$news = loadNews();

// 日付順にソート（新しい順）
usort($news, function ($a, $b) {
  return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<body>
<?php include __DIR__ . '/../header.php'; ?>
<?php
$page_title_en = "news";
$page_title_jp = "お知らせ";
$page_title_img = "/images/ttl/ttl.jpg";
include('../page-title.php');
?>
<main>
  <section class="news-content">
  <?php if (empty($news)): ?>
    <div class="no-news">
      <h3>お知らせはまだありません</h3>
      <p>新しいお知らせが投稿されるまでお待ちください。</p>
    </div>
    <?php else: ?>
    <div class="news-list">
    <?php foreach ($news as $item): ?>
      <article class="news-item">
      <div class="news-content-wrapper">
        <div class="news-text">
        <h2 class="news-title"><?php echo htmlspecialchars($item['title']); ?></h2>
        <div class="news-meta">
          <time datetime="<?php echo $item['created_at']; ?>">
          <?php echo date('Y年m月d日', strtotime($item['created_at'])); ?>
          </time>
        </div>
        <div class="news-body">
          <?php echo nl2br(htmlspecialchars($item['content'])); ?>
        </div>
        </div>

        <?php if ($item['image']): ?>
        <div class="news-image">
          <img src="/cms/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" onclick="openImageModal('<?php echo htmlspecialchars($item['image']); ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
        </div>
        <?php endif; ?>
      </div>
      </article>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>
  </section>

  <!-- 画像モーダル -->
  <div id="imageModal" class="modal" onclick="closeImageModal()">
    <div class="modal-content">
      <span class="close" onclick="closeImageModal()">&times;</span>
      <img id="modalImage" src="" alt="">
      <div id="modalCaption"></div>
    </div>
  </div>



</main>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>
