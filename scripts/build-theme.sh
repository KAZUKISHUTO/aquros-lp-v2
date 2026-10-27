#!/bin/sh
# 静的版の assets/ をWordPressテーマにコピーし、アップロード用のzipを作る
# 使い方: sh scripts/build-theme.sh
set -eu

cd "$(dirname "$0")/.."
theme=wp-theme/aquros-lp

# CSS・JSは圧縮版から読み込むため、先に style.min.css / main.min.js を作り直しておくこと
rm -rf "$theme/assets"
mkdir -p "$theme/assets"
cp -R assets/css assets/js assets/images assets/vendor "$theme/assets/"
find "$theme/assets" -name '.DS_Store' -delete

mkdir -p dist
rm -f dist/aquros-lp.zip
(cd wp-theme && zip -rq ../dist/aquros-lp.zip aquros-lp -x '*.DS_Store')

echo "作成しました: dist/aquros-lp.zip"
