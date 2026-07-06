<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="canonical" href="https://example.com">
  <title><?php echo $title ?? 'サイトタイトル｜キャッチコピー'; ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <!-- <meta name="robots" content="noindex"> -->
  <meta name="description" content="<?php echo $description ?? 'サイトの説明文をここに記載します。検索結果に表示される重要な文章です。'; ?>">
  <meta property="og:url" content="https://example.com">
  <meta property="og:site_name" content="<?php echo $title ?? 'サイトタイトル'; ?>">
  <meta property="og:title" content="<?php echo $title ?? 'サイトタイトル｜キャッチコピー'; ?>">
  <meta property="og:type" content="website">
  <meta property="og:description" content="<?php echo $description ?? 'サイトの説明文をここに記載します。検索結果に表示される重要な文章です。'; ?>">
  <meta property="og:image" content="https://example.com/images/common/ogp.jpg">
  <meta property="og:image:secure_url" content="https://example.com/images/common/ogp.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta name="twitter:title" content="<?php echo $title ?? 'サイトタイトル｜キャッチコピー'; ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:domain" content="https://example.com/">
  <meta name="twitter:image" content="https://example.com/images/common/ogp.jpg">
  <link rel="icon" href="/favicon.ico" sizes="32x32">
  <link rel="icon" href="/favicon.svg" sizes="any" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="stylesheet" href="/dest/ress.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="/dest/bundle.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/cms/frontend.css">
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
  <script src="/dest/bundle.js?v=<?php echo time(); ?>" defer></script>
  <script src="/cms/frontend.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- Google tag (gtag.js) -->
  <!--
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-XXXXXXXXXX');
  </script>
  -->

  <!-- JSON-LD 構造化データ（サンプル） -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "サンプル店舗",
      "url": "https://example.com/",
      "description": "店舗・サービスの説明文をここに記載します。",
      "telephone": "000-0000-0000",
      "address": {
        "@type": "PostalAddress",
        "postalCode": "000-0000",
        "addressRegion": "都道府県",
        "addressLocality": "市区町村",
        "streetAddress": "番地"
      },
      "openingHoursSpecification": [{
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
          "opens": "09:00",
          "closes": "18:00"
        }
      ]
    }
  </script>


</head>
