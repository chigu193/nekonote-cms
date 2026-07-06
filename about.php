<?php
$page_title = "アバウト - My Website";
include 'head.php';
?>

<body>
  <?php include 'header.php'; ?>

  <main>
    <section class="page-header">
      <h1>猫の手CMSについて</h1>
      <p>ちょっと助けてくれる便利なお知らせ簡易CMS</p>
    </section>


    <section class="cms-guide">
      <h2>猫の手CMS使い方ガイド</h2>
      <p class="guide-intro">このサイトには簡易CMSシステムが搭載されており、お知らせの管理が簡単に行えます。</p>

      <div class="guide-grid">
        <div class="guide-step">
          <div class="step-number">1</div>
          <h3>ログイン</h3>
          <p>トップページの「管理者ログイン」ボタンから管理画面にアクセスしてください。</p>
          <div class="login-info">
            <strong>現在のログイン情報:</strong><br>
            ユーザー名: <code>admin</code><br>
            パスワード: <code>password</code><br>
            <small>※パスワードは管理画面で変更可能</small>
          </div>
        </div>

        <div class="guide-step">
          <div class="step-number">2</div>
          <h3>お知らせ作成</h3>
          <p>「新しいお知らせを作成」ボタンをクリックして、タイトル・内容・投稿日時を入力。画像も1枚添付可能です。</p>
        </div>

        <div class="guide-step">
          <div class="step-number">3</div>
          <h3>投稿管理</h3>
          <p>ダッシュボードから既存の投稿を編集・削除できます。投稿日時の変更も可能です。</p>
        </div>

        <div class="guide-step">
          <div class="step-number">4</div>
          <h3>確認</h3>
          <p>投稿したお知らせは、トップページとお知らせ一覧ページに自動的に表示されます。画像はクリックで拡大表示。</p>
        </div>
        <div class="guide-step">
          <div class="step-number">5</div>
          <h3>パスワード変更</h3>
          <p>セキュリティのため、初期パスワードから強力なパスワードに変更することを推奨します。</p>
        </div>
        <div class="guide-step">
          <div class="step-number">6</div>
          <h3>ログアウト</h3>
          <p>作業が完了したら、必ずログアウトボタンでセッションを終了してください。</p>
        </div>
      </div>

      <div class="guide-features">
        <h3>CMS機能一覧</h3>
        <div class="feature-grid">
          <div class="feature-item">
            <strong>📝 投稿作成・編集</strong>
            <p>タイトル、コンテンツ、投稿日時を自由に設定</p>
          </div>
          <div class="feature-item">
            <strong>🖼️ 画像アップロード</strong>
            <p>1記事につき1枚の画像を添付可能。自動で800×600px以下にリサイズ＆画質80%に圧縮でサーバー負荷を軽減</p>
          </div>
          <div class="feature-item">
            <strong>📅 日時管理</strong>
            <p>投稿日時を過去・未来問わず設定可能（※予約投稿機能はなし、設定した日時で即座に投稿）</p>
          </div>
          <div class="feature-item">
            <strong>🔍 ポップアップ表示</strong>
            <p>画像をクリックすると拡大表示</p>
          </div>
          <div class="feature-item">
            <strong>📱 レスポンシブ対応</strong>
            <p>スマートフォンでも快適に利用可能</p>
          </div>
          <div class="feature-item">
            <strong>💾 JSON管理</strong>
            <p>データベース不要、JSONファイルで簡単管理</p>
          </div>
          <div class="feature-item">
            <strong>⚡ 画像自動最適化</strong>
            <p>PNG・GIF→JPEGに変換、サイズ・画質調整で高速表示とサーバー容量節約を実現</p>
          </div>
        </div>
      </div>

      <div class="guide-links">
        <a href="/cms/admin/login.php" class="btn btn-primary">管理画面へログイン</a>
        <a href="/news/" class="btn btn-secondary">お知らせ一覧を見る</a>
      </div>
    </section>

    <style>
      .page-header {
        text-align: center;
        padding: 60px 0;
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
      }

      .page-header h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 300;
      }

      .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
      }

      .about-content {
        padding: 60px 0;
      }

      .about-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 50px;
        align-items: start;
      }

      .about-text h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        font-size: 2rem;
      }

      .about-text h3 {
        color: #2c3e50;
        margin: 30px 0 15px 0;
        font-size: 1.3rem;
      }

      .about-text p {
        color: #666;
        line-height: 1.8;
        margin-bottom: 20px;
        font-size: 1.05rem;
      }

      .values-list {
        list-style: none;
        padding: 0;
      }

      .values-list li {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        color: #666;
        line-height: 1.6;
      }

      .values-list li:last-child {
        border-bottom: none;
      }

      .about-stats {
        background: white;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 20px;
      }

      .about-stats h3 {
        color: #2c3e50;
        margin-bottom: 30px;
        text-align: center;
        font-size: 1.3rem;
      }

      .stat-item {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
      }

      .stat-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
      }

      .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #3498db;
        margin-bottom: 10px;
      }

      .stat-label {
        color: #666;
        font-size: 0.9rem;
      }

      .contact-cta {
        background: #f8f9fa;
        padding: 60px 0;
        text-align: center;
        margin: 40px 0;
      }

      .contact-cta h2 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 2rem;
      }

      .contact-cta p {
        color: #666;
        margin-bottom: 30px;
        font-size: 1.1rem;
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

      @media (max-width: 768px) {
        .about-grid {
          grid-template-columns: 1fr;
          gap: 30px;
        }

        .about-stats {
          position: static;
        }

        .page-header h1 {
          font-size: 2rem;
        }

        .about-text h2 {
          font-size: 1.5rem;
        }

        .guide-grid {
          grid-template-columns: 1fr;
          gap: 20px;
        }

        .feature-grid {
          grid-template-columns: 1fr;
          gap: 20px;
        }

        .guide-links {
          flex-direction: column;
          gap: 15px;
        }
      }

      /* CMS Guide Styles */
      .cms-guide {
        padding: 60px 0;
        background: #f8f9fa;
      }

      .cms-guide h2 {
        text-align: center;
        color: #2c3e50;
        font-size: 2rem;
        margin-bottom: 20px;
        font-weight: 300;
      }

      .guide-intro {
        text-align: center;
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 50px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
      }

      .guide-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding: 0 20px;
      }

      .guide-step {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
        position: relative;
        transition: transform 0.3s ease;
      }

      .guide-step:hover {
        transform: translateY(-3px);
      }

      .step-number {
        background: #3498db;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0 auto 20px;
      }

      .guide-step h3 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.3rem;
      }

      .guide-step p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
      }

      .login-info {
        background: #e8f4fd;
        padding: 15px;
        border-radius: 5px;
        font-size: 0.9rem;
        color: #2c3e50;
      }

      .login-info code {
        background: #fff;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Monaco', monospace;
        color: #e74c3c;
      }

      .guide-features {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 40px;
      }

      .guide-features h3 {
        text-align: center;
        color: #2c3e50;
        font-size: 1.5rem;
        margin-bottom: 30px;
      }

      .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
      }

      .feature-item {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
      }

      .feature-item strong {
        color: #2c3e50;
        display: block;
        margin-bottom: 8px;
        font-size: 1rem;
      }

      .feature-item p {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0;
      }

      .guide-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .btn-primary {
        background: #3498db;
        color: white;
      }

      .btn-primary:hover {
        background: #2980b9;
      }

      .btn-secondary {
        background: #95a5a6;
        color: white;
      }

      .btn-secondary:hover {
        background: #7f8c8d;
      }
    </style>
  </main>

  <?php include 'footer.php'; ?>
</body>

</html>
