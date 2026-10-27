<?php
/**
 * トップページ（LP）
 *
 * @package aquros-lp
 */

get_header();

get_template_part( 'template-parts/section', 'fv' );
get_template_part( 'template-parts/section', 'worries' );
get_template_part( 'template-parts/section', 'message' );
get_template_part( 'template-parts/section', 'reason' );
get_template_part( 'template-parts/section', 'appeal' );
get_template_part( 'template-parts/section', 'service' );
get_template_part( 'template-parts/section', 'works' );
get_template_part( 'template-parts/section', 'flow' );
get_template_part( 'template-parts/section', 'faq' );
get_template_part( 'template-parts/section', 'contact' );

get_footer();
