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
              $area   = aquros_field( 'works_area' );
              $period = aquros_field( 'works_period' );
              $cost   = aquros_field( 'works_cost' );
              $meta   = array_filter(
                array(
                  $period ? '工期 ' . $period : '',
                  $cost ? '費用 ' . $cost : '',
                )
              );
              ?>
            <article class="work-card carousel__slide">
              <?php if ( has_post_thumbnail() ) : ?>
              <div class="work-card__visual">
                <?php the_post_thumbnail( 'aquros-work', array( 'class' => 'work-card__image', 'loading' => 'lazy' ) ); ?>
              </div>
              <?php else : ?>
              <div class="work-card__visual work-card__visual--placeholder">写真準備中</div>
              <?php endif; ?>
              <?php if ( $area ) : ?>
              <span class="work-card__area"><?php echo esc_html( $area ); ?></span>
              <?php endif; ?>
              <h3 class="work-card__title"><?php the_title(); ?></h3>
              <?php if ( $meta ) : ?>
              <p class="work-card__meta"><?php echo esc_html( implode( '／', $meta ) ); ?></p>
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
      </div>
    </section>
