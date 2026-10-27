# AQUROS リフォームLP（D案 Ver2・イラスト調）

松戸・柏エリア向け、水回り以外のリフォーム（住宅リペア・フローリング上張り・窓ガラスフィルム）のLP。
「LPコーディング規約 v0.3」に準拠した静的HTML・CSS・JavaScriptで構成している。

## ファイル構成

```text
aquros-lp-v2/
├── index.html
├── README.md
├── scripts/
│   └── build-theme.sh       WordPressテーマのzipを作る
├── wp-theme/
│   └── aquros-lp/           WordPressテーマ
└── assets/
    ├── css/
    │   ├── reset.css        全リセット型
    │   ├── style.css        開発用（編集はこちら）
    │   └── style.min.css    本番用（style.cssから生成）
    ├── js/
    │   ├── main.js          開発用（編集はこちら）
    │   └── main.min.js      本番用（main.jsから生成）
    ├── images/
    │   └── illust/          イラスト（SVG）
    ├── fonts/               現状未使用（Google Fontsで配信）
    └── vendor/
        └── gsap/            GSAP 3.12.5（gsap.min.js / ScrollTrigger.min.js）
```

## 編集と圧縮ファイルの生成

`style.min.css`・`main.min.js`は直接編集しない。元ファイルを編集したあと、次のコマンドで再生成する。

```bash
npx csso-cli@4 assets/css/style.css -o assets/css/style.min.css
npx terser@5 assets/js/main.js -c -m -o assets/js/main.min.js
```

## 実装メモ

- ブレークポイント：`min-width: 768px` と `min-width: 1024px`（モバイルファースト）
- CSS変数は`style.css`冒頭の`:root`で管理（色・フォント・余白・コンテンツ幅）
- フォント：Noto Sans JP（400/500/700）のみ
- イラストはすべてオリジナルのSVG（`assets/images/illust/`）。線色 #2B4A5C・差し色 #B85016 で統一しており、色を変える場合はSVGファイル内の値を置換する
- SVG内の文字（FVの「まとめて相談OK」「ドア」など）は`<img>`読み込みのためWebフォントが効かず、端末の日本語フォントで表示される
- アニメーション：`data-animate`を付けた要素をスクロールでフェードイン。`prefers-reduced-motion`有効時とGSAP未読込時は動かさず、そのまま表示する
- 画面下部の固定LINEボタンは1024px未満のみ表示。FVと問い合わせ欄のLINEボタンが見えている間は隠す
- LINEボタンには計測用に`data-cta`属性（`line-header` / `line-fv` / `line-appeal` / `line-contact` / `line-fixed` / `tel-contact`）を付与している。GA4・Meta広告のクリック計測に利用する想定

## 公開前に差し替えが必要な箇所（index.html内のTODO）

| 箇所 | 内容 |
|---|---|
| LINEボタン（5か所） | `https://lin.ee/XXXXXXX` をLINE公式アカウントの友だち追加URLに一括置換 |
| 問い合わせ欄のQRコード | `contact__qr-placeholder` を QRコード画像（`assets/images/line-qr.png` 想定）に差し替え |
| 施工事例 | 掲載許可済みの施工写真と工事情報（エリア・工事名・工期・費用）に差し替え |
| プライバシーポリシー | フッターのリンク先URLを設定 |

あわせて、OGP（`og:image`等）、favicon、GA4・広告タグを公開環境に合わせて追加する。

## 画像素材

| ファイル | 使用箇所 | 出典 |
|---|---|---|
| illust/*.svg | FV・お悩み・選ばれる理由・サービス・流れ・問い合わせ | 本LP用に制作したオリジナルイラスト |
| ceo.webp | 代表あいさつ | クライアント提供（代表 廣瀬 学） |
| line-icon.png | LINEボタン | LINEヤフー提供の公式アイコン（無改変・縮小のみ） |

- LINEアイコンはLINEヤフーのロゴガイドライン（クリアスペース等）を公開前に確認すること。

## WordPressテーマ

`wp-theme/aquros-lp/` にWordPressテーマがある。静的版の`index.html`をセクションごとに分割したもので、見た目・CSS・JSは静的版と共通。

```text
wp-theme/aquros-lp/
├── style.css            テーマ情報のみ（スタイルは assets/css/style.min.css）
├── functions.php        アセット読み込み・タイトル/OGP・カスタマイザー・カスタム投稿・ACF
├── header.php / footer.php
├── front-page.php       トップページ（template-partsを順に読み込む）
├── index.php            固定ページ（プライバシーポリシーなど）
├── screenshot.png
└── template-parts/      section-*.php（各セクション）
```

### アップロード用zipの作成

テーマの`assets/`はリポジトリに含めず、静的版の`assets/`からコピーして作る（二重管理を防ぐため）。

```bash
sh scripts/build-theme.sh   # dist/aquros-lp.zip ができる
```

管理画面の「外観 > テーマ > 新規追加 > テーマのアップロード」で`dist/aquros-lp.zip`をアップロードし、有効化する。

### 管理画面で更新する項目

| 項目 | 場所 |
|---|---|
| LINE 友だち追加URL・QRコード画像・電話番号 | 外観 > カスタマイズ > AQUROS 連絡先 |
| 施工事例（工事名・写真・地域・工期・費用・並び順） | 施工事例（カスタム投稿）。地域・工期・費用はACFの入力欄 |
| プライバシーポリシーのリンク | 設定 > プライバシー で選んだページ（未設定ならリンクを出さない） |
| ファビコン | 外観 > カスタマイズ > サイト基本情報 > サイトアイコン（未設定ならテーマの画像を使う） |

- 必要なプラグイン：Advanced Custom Fields（無料版）。入力欄は`functions.php`で登録しているため、ACF側での設定は不要
- 施工事例が1件もない間は、施工事例セクションとメニューの項目を表示しない
- タイトル・説明文・OGPは`functions.php`の`aquros_page_meta()`で出力している。SEOプラグインを入れる場合は二重出力にならないよう、`aquros_output_meta`のフックを外す
- 本文の文章（お悩み・できること・FAQなど）は`template-parts/`に直接書いている。変更するときは静的版の`index.html`と両方を直す
- 必要環境：WordPress 6.3以上、PHP 7.4以上

## 確認状況

- 390px / 768px / 1280px で表示確認済み（横スクロールなし、画像読み込み・アニメーション・固定ボタンの切り替えを確認）
- WordPressテーマは WordPress Playground（WordPress 7.1 / PHP 8.3、ACF有効）で動作確認済み（PHPエラーなし、施工事例のループ・ACF入力欄・カスタマイザー・管理バー表示時のヘッダー位置を確認）
- 実機（iOS Safari / Android Chrome）での確認、PageSpeed Insightsでの計測は未実施
