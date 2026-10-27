<?php
/**
 * トップページ以外の表示（プライバシーポリシーなどの固定ページ）
 *
 * @package aquros-lp
 */

get_header();
?>
    <section class="page">
      <div class="page__inner">
        <?php
        while ( have_posts() ) :
          the_post();
          ?>
        <h1 class="page__title"><?php the_title(); ?></h1>
        <div class="page__content">
          <?php the_content(); ?>
        </div>
          <?php
        endwhile;
        ?>
      </div>
    </section>
<?php
get_footer();
