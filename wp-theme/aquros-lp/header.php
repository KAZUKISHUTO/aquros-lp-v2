<?php
/**
 * ヘッダー（<head>・ヘッダー・メニュー）
 *
 * @package aquros-lp
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="#top" aria-label="AQUROS（アクラス）ページの先頭へ">
        <span class="header__logo-en">AQUROS</span>
        <span class="header__logo-ja">アクラス</span>
      </a>
      <div class="header__actions">
        <a class="button button--line button--small header__line" href="<?php echo esc_url( aquros_line_url() ); ?>" aria-label="LINEで相談する" data-cta="line-header">
          <img class="button__icon" src="<?php aquros_asset( 'images/line-icon.png' ); ?>" alt="" width="24" height="24">
          <span class="button__label">相談する</span>
        </a>
        <button class="menu-button" type="button" aria-expanded="false" aria-controls="drawer" data-menu-open>
          <span class="menu-button__icon" aria-hidden="true"><span class="menu-button__bar"></span><span class="menu-button__bar"></span><span class="menu-button__bar"></span></span>
          <span class="menu-button__label">メニュー</span>
        </button>
      </div>
    </div>
  </header>

  <div class="drawer" id="drawer" data-drawer>
    <div class="drawer__overlay" data-menu-close></div>
    <div class="drawer__panel" role="dialog" aria-modal="true" aria-label="メニュー" data-drawer-panel>
      <div class="drawer__head">
        <p class="drawer__logo">AQUROS<span class="drawer__logo-ja">アクラス</span></p>
        <button class="menu-button" type="button" data-menu-close>
          <span class="menu-button__icon menu-button__icon--close" aria-hidden="true"></span>
          <span class="menu-button__label">閉じる</span>
        </button>
      </div>
      <nav class="drawer__nav" aria-label="ページ内">
        <ul class="drawer__list">
          <li class="drawer__item" style="--i: 0"><a class="drawer__link" href="#worries" data-menu-link>こんなお困りごと</a></li>
          <li class="drawer__item" style="--i: 1"><a class="drawer__link" href="#message" data-menu-link>代表からのごあいさつ</a></li>
          <li class="drawer__item" style="--i: 2"><a class="drawer__link" href="#reason" data-menu-link>選ばれる3つのこと</a></li>
          <li class="drawer__item" style="--i: 3"><a class="drawer__link" href="#service" data-menu-link>AQUROSにできること</a></li>
          <?php if ( aquros_works_query()->have_posts() ) : ?>
          <li class="drawer__item" style="--i: 4"><a class="drawer__link" href="#works" data-menu-link>施工事例</a></li>
          <?php endif; ?>
          <li class="drawer__item" style="--i: 5"><a class="drawer__link" href="#flow" data-menu-link>ご相談の流れ</a></li>
          <li class="drawer__item" style="--i: 6"><a class="drawer__link" href="#faq" data-menu-link>よくあるご質問</a></li>
          <li class="drawer__item" style="--i: 7"><a class="drawer__link" href="#contact" data-menu-link>お問い合わせ</a></li>
        </ul>
      </nav>
      <div class="drawer__contact">
        <a class="button button--line button--block" href="<?php echo esc_url( aquros_line_url() ); ?>" data-cta="line-drawer">
          <img class="button__icon" src="<?php aquros_asset( 'images/line-icon.png' ); ?>" alt="" width="24" height="24">
          <span class="button__label">LINEで相談する</span>
        </a>
        <a class="drawer__tel" href="<?php echo esc_url( aquros_tel_href() ); ?>" data-cta="tel-drawer">
          <span class="drawer__tel-label">お電話も24時間365日受付</span>
          <span class="drawer__tel-number"><?php echo esc_html( aquros_tel() ); ?></span>
        </a>
      </div>
    </div>
  </div>

  <main>
