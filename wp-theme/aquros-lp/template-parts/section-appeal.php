<?php
/**
 * 0円・24時間受付のアピール
 *
 * @package aquros-lp
 */

?>
    <section class="appeal">
      <div class="appeal__inner">
        <div class="appeal__heading" data-animate>
          <p class="appeal__eyebrow">松戸の水まわりの、かかりつけ窓口</p>
          <h2 class="appeal__title">水まわりのことは、<br>まずAQUROSに<br class="br-sp">聞けばいい。</h2>
        </div>
        <ul class="appeal__list" data-animate="stagger">
          <li class="appeal__item"><span class="appeal__label">出張点検</span><strong class="appeal__value appeal__value--accent">0円</strong></li>
          <li class="appeal__item"><span class="appeal__label">お見積もり</span><strong class="appeal__value appeal__value--accent">0円</strong></li>
          <li class="appeal__item"><span class="appeal__label">ご相談受付</span><strong class="appeal__value">24時間<br>365日</strong></li>
          <li class="appeal__item"><span class="appeal__label">お支払い</span><strong class="appeal__value">カードOK</strong></li>
        </ul>
        <a class="button button--line button--round" href="<?php echo esc_url( aquros_line_url() ); ?>" data-cta="line-appeal" data-animate>
          <img class="button__icon" src="<?php aquros_asset( 'images/line-icon.png' ); ?>" alt="" width="24" height="24">
          <span class="button__label">LINEで相談してみる</span>
        </a>
      </div>
    </section>
