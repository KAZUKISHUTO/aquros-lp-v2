<?php
/**
 * トップページ以外の表示（プライバシーポリシーなどの固定ページ）
 *
 * @package aquros-lp
 */

get_header();
?>
    <section class="subpage">
      <div class="subpage__inner">
        <?php
        while ( have_posts() ) :
          the_post();
          ?>
        <h1 class="subpage__title"><?php the_title(); ?></h1>
        <div class="subpage__content">
          <?php the_content(); ?>
        </div>
          <?php
        endwhile;
        ?>
      </div>
    </section>
<?php
get_footer();
