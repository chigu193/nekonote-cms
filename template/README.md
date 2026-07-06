# 猫の手CMS テンプレート

このフォルダをそのままコピーしてサイトのルートとして使ってください。

## 使い方

1. このフォルダごとコピー
2. サーバーのドキュメントルートに配置
3. `head.php` のサイト情報を書き換え（タイトル、説明、URL等）
4. `/cms/admin/` から管理画面にアクセス

## フォルダ構成

```
template/
├── cms/           # CMS本体（お知らせ管理）
│   ├── admin/     # 管理画面
│   ├── data/      # データ（JSON）
│   └── uploads/   # アップロード画像
├── dest/          # CSS/JS
├── images/        # 画像素材
├── about/         # 下層ページ例
├── news/          # お知らせ一覧
├── head.php       # <head>共通部分 ※要編集
├── header.php     # ヘッダー
├── footer.php     # フッター
└── index.php      # トップページ
```

## 初期設定で変更する箇所

- `head.php` - サイトタイトル、URL、説明文、OGP、Google Analytics ID
- `header.php` - ロゴ画像
- `images/common/` - ロゴやOGP画像を差し替え
