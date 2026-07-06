<?php // PHPタグ開始（ここで変数の処理などを書く） ?>
<section class="bl_ttl_over">
  <section class="ly_contLg">
  <div class="bl_ttl_wrap">
    <p class="bl_ttl_ttl_en">
    <?php echo isset($page_title_en) ? htmlspecialchars($page_title_en) : ""; ?>
    </p>
    <h1 class="bl_ttl_ttl">
    <?php echo isset($page_title_jp) ? htmlspecialchars($page_title_jp) : ""; ?>
    </h1>
    <img class="bl_ttl_img" src="<?php echo isset($page_title_img) ? htmlspecialchars($page_title_img) : ""; ?>">
  </div>
  </section>
</section>
