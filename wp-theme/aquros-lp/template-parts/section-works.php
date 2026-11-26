<?php
/**
 * 施工事例（カスタム投稿「works」）
 *
 * 事例が1件もないときは、セクションごと表示しない。
 *
 * @package aquros-lp
 */

$works = aquros_works_query();
if ( ! $works->have_posts() ) {
	return;
}
?>
    <section class="works" id="works">
      <div class="works__inner">
        <div class="section-heading" data-animate>
          <p class="section-heading__eyebrow">ビフォー・アフター</p>
          <h2 class="section-heading__title">施工事例</h2>
        </div>
        <div class="carousel" role="region" aria-roledescription="カルーセル" aria-label="施工事例" data-carousel>
          <div class="carousel__viewport" data-carousel-viewport>
            <?php
            while ( $works->have_posts() ) :
              $works->the_post();
              $before = aquros_image_field( 'works_before' );
              $after  = aquros_image_field( 'works_after' );
              $area   = aquros_field( 'works_area' );
              $period  = aquros_field( 'works_period' );
              $comment = aquros_field( 'works_comment' );
              ?>
            <article class="work-card carousel__slide">
              <?php if ( $before && $after ) : ?>
              <div class="work-card__compare">
                <figure class="work-card__photo">
                  <?php echo wp_get_attachment_image( $before, 'aquros-work-compare', false, array( 'class' => 'work-card__image', 'alt' => get_the_title() . 'の施工前', 'loading' => 'lazy', 'data-full' => wp_get_attachment_image_url( $before, 'large' ) ) ); ?>
                  <figcaption class="work-card__label">施工前</figcaption>
                </figure>
                <figure class="work-card__photo">
                  <?php echo wp_get_attachment_image( $after, 'aquros-work-compare', false, array( 'class' => 'work-card__image', 'alt' => get_the_title() . 'の施工後', 'loading' => 'lazy', 'data-full' => wp_get_attachment_image_url( $after, 'large' ) ) ); ?>
                  <figcaption class="work-card__label work-card__label--after">施工後</figcaption>
                </figure>
                <span class="work-card__arrow" aria-hidden="true"></span>
                <button class="work-card__zoom" type="button" hidden data-work-zoom aria-label="<?php the_title_attribute(); ?>の写真を拡大して見る"><span class="work-card__zoom-label"><svg class="work-card__zoom-icon" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"></circle><path d="m15.5 15.5 5 5M10.5 7.5v6M7.5 10.5h6"></path></svg>拡大</span></button>
              </div>
              <?php elseif ( has_post_thumbnail() ) : ?>
              <div class="work-card__visual">
                <?php the_post_thumbnail( 'aquros-work', array( 'class' => 'work-card__image', 'loading' => 'lazy', 'data-full' => get_the_post_thumbnail_url( null, 'large' ) ) ); ?>
                <button class="work-card__zoom" type="button" hidden data-work-zoom aria-label="<?php the_title_attribute(); ?>の写真を拡大して見る"><span class="work-card__zoom-label"><svg class="work-card__zoom-icon" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"></circle><path d="m15.5 15.5 5 5M10.5 7.5v6M7.5 10.5h6"></path></svg>拡大</span></button>
              </div>
              <?php else : ?>
              <div class="work-card__visual work-card__visual--placeholder">写真準備中</div>
              <?php endif; ?>
              <?php if ( $area ) : ?>
              <span class="work-card__area"><?php echo esc_html( $area ); ?></span>
              <?php endif; ?>
              <h3 class="work-card__title"><?php the_title(); ?></h3>
              <?php if ( $period ) : ?>
              <p class="work-card__meta">工期 <?php echo esc_html( $period ); ?></p>
              <?php endif; ?>
              <?php if ( $comment ) : ?>
              <p class="work-card__comment"><?php echo esc_html( $comment ); ?></p>
              <?php endif; ?>
            </article>
              <?php
            endwhile;
            wp_reset_postdata();
            ?>
          </div>
          <div class="carousel__controls" hidden data-carousel-controls>
            <button class="carousel__button" type="button" aria-label="前の事例へ" data-carousel-prev><svg class="carousel__icon" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5 8 12l7 7"></path></svg></button>
            <div class="carousel__dots" data-carousel-dots></div>
            <button class="carousel__button" type="button" aria-label="次の事例へ" data-carousel-next><svg class="carousel__icon" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 5 7 7-7 7"></path></svg></button>
          </div>
        </div>
        <dialog class="work-modal" aria-labelledby="work-modal-title" data-work-modal>
          <div class="work-modal__inner">
            <div class="work-modal__head">
              <p class="work-modal__title" id="work-modal-title" data-work-modal-title></p>
              <button class="menu-button" type="button" data-work-modal-close>
                <span class="menu-button__icon menu-button__icon--close" aria-hidden="true"></span>
                <span class="menu-button__label">閉じる</span>
              </button>
            </div>
            <div class="work-modal__photos" data-work-modal-photos></div>
          </div>
        </dialog>
      </div>
    </section>
