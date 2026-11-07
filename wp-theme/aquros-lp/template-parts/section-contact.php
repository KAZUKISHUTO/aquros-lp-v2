<?php
/**
 * お問い合わせ
 *
 * @package aquros-lp
 */

?>
    <section class="contact" id="contact">
      <div class="contact__inner">
        <img class="contact__illust" src="<?php aquros_asset( 'images/illust/contact-phone.svg' ); ?>" alt="" width="240" height="160" loading="lazy">
        <div class="section-heading" data-animate>
          <h2 class="section-heading__title">写真を1枚送るだけ。<br>まずはLINEでどうぞ</h2>
          <p class="section-heading__lead section-heading__lead--left">困ったときに、頼れるプロがいます。何から直せばいいか決まっていなくても大丈夫。点検・お見積もりは0円です。</p>
        </div>
        <ol class="contact__steps" data-animate="stagger">
          <li class="contact__step"><span class="contact__number">STEP 1</span><strong class="contact__step-title">友だち追加</strong><span class="contact__step-text">下のボタンから、AQUROSのLINEを追加します。</span></li>
          <li class="contact__step"><span class="contact__number">STEP 2</span><strong class="contact__step-title">写真とひとことを送る</strong><span class="contact__step-text">「トイレの水が止まらない」など、短くて大丈夫です。</span></li>
          <li class="contact__step"><span class="contact__number">STEP 3</span><strong class="contact__step-title">担当者からお返事</strong><span class="contact__step-text">内容を見て、トークでお返事します。</span></li>
        </ol>
        <div class="contact__action" data-hide-fixed-cta>
          <a class="button button--line button--xlarge" href="<?php echo esc_url( aquros_line_url() ); ?>" data-cta="line-contact">
            <img class="button__icon button__icon--large" src="<?php aquros_asset( 'images/line-icon.png' ); ?>" alt="" width="32" height="32">
            <span class="button__label">LINEで相談する</span>
          </a>
          <div class="contact__qr">
            <?php if ( get_theme_mod( 'aquros_line_qr' ) ) : ?>
              <?php echo wp_get_attachment_image( get_theme_mod( 'aquros_line_qr' ), 'medium', false, array( 'class' => 'contact__qr-image', 'alt' => 'LINE友だち追加用のQRコード', 'loading' => 'lazy' ) ); ?>
            <?php else : ?>
            <!-- QRコード画像は「外観 > カスタマイズ > AQUROS 連絡先」で設定 -->
            <div class="contact__qr-placeholder">QRコード</div>
            <?php endif; ?>
            <p class="contact__qr-text">パソコンでご覧の方は<br>スマートフォンで<br>読み取ってください</p>
          </div>
        </div>
        <p class="contact__tel">お電話も24時間365日受付<br><a class="contact__tel-link" href="<?php echo esc_url( aquros_tel_href() ); ?>" data-cta="tel-contact"><?php echo esc_html( aquros_tel() ); ?></a></p>
      </div>
    </section>
