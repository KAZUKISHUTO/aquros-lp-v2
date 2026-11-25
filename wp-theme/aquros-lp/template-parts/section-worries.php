<?php
/**
 * お悩み
 *
 * @package aquros-lp
 */

?>
    <section class="worries" id="worries">
      <div class="worries__inner">
        <div class="section-heading" data-animate>
          <p class="section-heading__eyebrow">水まわりの「ちょっと困った」</p>
          <h2 class="section-heading__title">こんなお悩みは<br>ありませんか？</h2>
        </div>
        <ul class="worries__list" data-animate="stagger">
          <!-- TODO: 補足文（2行目）は仮。お客様に確認のうえ確定 -->
          <li class="worry-card">
            <img class="worry-card__icon" src="<?php aquros_asset( 'images/illust/worry-years.svg' ); ?>" alt="" width="64" height="64" loading="lazy">
            <p class="worry-card__body"><strong class="worry-card__title">10〜15年経過して、耐久性が不安になってきた</strong><span class="worry-card__text">毎日使う水まわりは、年数とともに少しずつ傷んでいきます。</span></p>
          </li>
          <li class="worry-card">
            <img class="worry-card__icon" src="<?php aquros_asset( 'images/illust/worry-creak.svg' ); ?>" alt="" width="64" height="64" loading="lazy">
            <p class="worry-card__body"><strong class="worry-card__title">ミシミシ音が気になる…</strong><span class="worry-card__text">お風呂やトイレの床がきしむ。見えないところで傷みが進んでいないか心配。</span></p>
          </li>
          <li class="worry-card">
            <img class="worry-card__icon" src="<?php aquros_asset( 'images/illust/worry-timing.svg' ); ?>" alt="" width="64" height="64" loading="lazy">
            <p class="worry-card__body"><strong class="worry-card__title">そろそろ交換時期かもしれない…</strong><span class="worry-card__text">まだ使えるけれど、いつ替えればいいのか分からない。</span></p>
          </li>
        </ul>
        <p class="worries__closing">ひとつでも当てはまったら、<br><span class="marker">まずは写真を1枚、</span><br><span class="marker">送ってみてください。</span></p>
      </div>
    </section>
