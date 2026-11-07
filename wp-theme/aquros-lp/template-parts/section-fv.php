<?php
/**
 * ファーストビュー
 *
 * @package aquros-lp
 */

?>
    <section class="fv" id="top">
      <div class="fv__inner">
        <div class="fv__main">
          <h1 class="fv__title">
            <span class="fv__title-line">「どこに頼めば…」</span>
            <span class="fv__title-line">と迷ったら、</span>
            <span class="fv__title-line">松戸のAQUROSへ。</span>
          </h1>
          <img class="fv__illust" src="<?php aquros_asset( 'images/illust/fv-house.svg' ); ?>" alt="お風呂・洗面所・キッチン・トイレなど、家の水まわりをまとめて相談できることを表したイラスト" width="480" height="400" fetchpriority="high">
        </div>
        <div class="fv__body">
          <p class="fv__lead">松戸・柏で、15,000件以上のご依頼をいただいてきました<span class="fv__mark">※</span></p>
          <p class="fv__text">お風呂、トイレ、キッチン、洗面所。水まわりのリフォームや配管工事は、場所ごとに別の業者を探さなくても大丈夫。まとめてAQUROSにご相談ください。</p>
          <ul class="tag-list">
            <li class="tag-list__item">点検・お見積もり0円</li>
            <li class="tag-list__item">24時間365日受付</li>
            <li class="tag-list__item">カード払いOK</li>
          </ul>
          <div class="cta-box" data-hide-fixed-cta>
            <p class="cta-box__lead">気になるところを写真で送るだけ。<br>おおよその費用をお伝えします</p>
            <a class="button button--line button--large" href="<?php echo esc_url( aquros_line_url() ); ?>" data-cta="line-fv">
              <img class="button__icon" src="<?php aquros_asset( 'images/line-icon.png' ); ?>" alt="" width="24" height="24">
              <span class="button__label">LINEで相談する</span>
            </a>
            <p class="cta-box__note">お電話も24時間受付 <a href="<?php echo esc_url( aquros_tel_href() ); ?>"><?php echo esc_html( aquros_tel() ); ?></a><br>※水まわり工事を含む、当社の累計ご依頼件数です</p>
          </div>
        </div>
      </div>
    </section>
