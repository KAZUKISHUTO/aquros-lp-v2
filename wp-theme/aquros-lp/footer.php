<?php
/**
 * フッター（フッター・固定CTA）
 *
 * @package aquros-lp
 */

?>
  </main>

  <footer class="footer">
    <div class="footer__inner">
      <div class="footer__info">
        <p class="footer__logo">AQUROS<span class="footer__logo-ja">アクラス</span></p>
        <p class="footer__address">運営会社：株式会社廣瀬興業<br>代表取締役：廣瀬 学<br>松戸市指定工事店<br>〒270-0021 千葉県松戸市小金原4-11-11 鈴木店舗102<br>TEL <?php echo esc_html( aquros_tel() ); ?>／FAX 047-710-9009</p>
        <div class="footer__sns">
          <p class="footer__sns-title">SNSでもAQUROSをチェック</p>
          <ul class="footer__sns-list">
            <li><a class="sns-link" href="https://www.instagram.com/aquros_matsudo/" target="_blank" rel="noopener">Instagram<svg class="sns-link__icon" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h6v6"></path><path d="M10 14 21 3"></path><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path></svg></a></li>
            <li><a class="sns-link" href="https://www.tiktok.com/@aquros7" target="_blank" rel="noopener">TikTok<svg class="sns-link__icon" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h6v6"></path><path d="M10 14 21 3"></path><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path></svg></a></li>
          </ul>
        </div>
      </div>
      <nav class="footer__nav" aria-label="フッター">
        <?php if ( get_privacy_policy_url() ) : ?>
        <a class="footer__link" href="<?php echo esc_url( get_privacy_policy_url() ); ?>">プライバシーポリシー</a>
        <?php endif; ?>
        <a class="footer__link" href="#top">ページの先頭へ</a>
      </nav>
    </div>
    <p class="footer__copyright"><small>&copy; AQUROS / 株式会社廣瀬興業</small></p>
  </footer>

  <div class="fixed-cta" data-fixed-cta>
    <a class="button button--line button--block" href="<?php echo esc_url( aquros_line_url() ); ?>" data-cta="line-fixed">
      <img class="button__icon" src="<?php aquros_asset( 'images/line-icon.png' ); ?>" alt="" width="24" height="24">
      <span class="button__label">LINEで相談する</span>
    </a>
  </div>

  <?php wp_footer(); ?>
</body>
</html>
