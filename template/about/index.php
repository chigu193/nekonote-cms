<?php
$title = '〇〇について';
// $description = '';
include __DIR__ . '/../head.php';
?>

<body>
  <?php include __DIR__ . '/../header.php'; ?>
  <?php
  $page_title_en = "about";
  $page_title_jp = "〇〇について";
  $page_title_img = "/images/ttl/ttl.jpg";
  include __DIR__ . '/../page-title.php';
  ?>
  <main>

  <section class="ly_wrap">
    <div class="ly_cont">
    ここに本文
    </div>
  </section>
  </main>
  <?php include __DIR__ . '/../footer.php'; ?>
</body>

</html>
