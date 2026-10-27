<?php
/**
 * AQUROS LP テーマの機能
 *
 * @package aquros-lp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ページのタイトル・説明文（OGPと共通）
 *
 * SEOプラグインを入れる場合は、aquros_output_meta() のフックを外してプラグイン側で設定する。
 */
function aquros_page_meta() {
	return array(
		'title'       => '松戸・柏の住まいのリペア・リフォーム相談｜AQUROS（アクラス）',
		'description' => '床のキズ、ドアの調子、夏の西日に冬の冷え。おうちの「ちょっと困った」をまとめて相談できる、松戸市小金原のAQUROS（アクラス）。点検・お見積もり0円、LINEで写真を送るだけで概算がわかります。',
		'image_alt'   => '「どこに頼めば…」と迷ったら、松戸のAQUROSへ。お風呂・洗面台・キッチン・トイレの交換',
	);
}

/**
 * テーマの基本設定
 */
function aquros_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'script', 'style' ) );
	// 施工事例の写真（カードの表示比率 4:3）
	add_image_size( 'aquros-work', 640, 480, true );
}
add_action( 'after_setup_theme', 'aquros_setup' );

/**
 * テーマ内ファイルのURL
 *
 * @param string $path assets/ からの相対パス。
 */
function aquros_get_asset_uri( $path ) {
	return get_theme_file_uri( 'assets/' . ltrim( $path, '/' ) );
}

/**
 * テーマ内ファイルのURLを出力する
 *
 * @param string $path assets/ からの相対パス。
 */
function aquros_asset( $path ) {
	echo esc_url( aquros_get_asset_uri( $path ) );
}

/**
 * 更新日時をバージョンにして、ファイルを差し替えたときにキャッシュが残らないようにする
 *
 * @param string $path assets/ からの相対パス。
 */
function aquros_asset_version( $path ) {
	$file = get_theme_file_path( 'assets/' . ltrim( $path, '/' ) );
	return file_exists( $file ) ? (string) filemtime( $file ) : null;
}

/**
 * CSS・JavaScriptの読み込み
 */
function aquros_enqueue_assets() {
	wp_enqueue_style( 'aquros-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap', array(), null );
	wp_enqueue_style( 'aquros-reset', aquros_get_asset_uri( 'css/reset.css' ), array(), aquros_asset_version( 'css/reset.css' ) );
	wp_enqueue_style( 'aquros-style', aquros_get_asset_uri( 'css/style.min.css' ), array( 'aquros-reset' ), aquros_asset_version( 'css/style.min.css' ) );

	$defer = array( 'strategy' => 'defer' );
	wp_enqueue_script( 'gsap', aquros_get_asset_uri( 'vendor/gsap/gsap.min.js' ), array(), '3.12.5', $defer );
	wp_enqueue_script( 'gsap-scrolltrigger', aquros_get_asset_uri( 'vendor/gsap/ScrollTrigger.min.js' ), array( 'gsap' ), '3.12.5', $defer );
	wp_enqueue_script( 'aquros-main', aquros_get_asset_uri( 'js/main.min.js' ), array( 'gsap', 'gsap-scrolltrigger' ), aquros_asset_version( 'js/main.min.js' ), $defer );

	// ブロックエディタ用のCSSはLPでは使わず、リセットCSSと競合するため読み込まない
	if ( is_front_page() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'aquros_enqueue_assets', 20 );

/**
 * Google Fontsへの事前接続
 *
 * @param array  $urls          出力するURL。
 * @param string $relation_type preconnect など。
 */
function aquros_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'aquros_resource_hints', 10, 2 );

// 絵文字用のスクリプトはLPでは不要
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * トップページのタイトル
 *
 * @param string $title 通常のタイトル。
 */
function aquros_document_title( $title ) {
	if ( is_front_page() ) {
		$meta = aquros_page_meta();
		return $meta['title'];
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'aquros_document_title' );

/**
 * 説明文・OGP・ファビコンを出力する
 */
function aquros_output_meta() {
	if ( ! is_front_page() ) {
		return;
	}
	$meta = aquros_page_meta();
	?>
	<meta name="description" content="<?php echo esc_attr( $meta['description'] ); ?>">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="AQUROS（アクラス）">
	<meta property="og:title" content="<?php echo esc_attr( $meta['title'] ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $meta['description'] ); ?>">
	<meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>">
	<meta property="og:image" content="<?php aquros_asset( 'images/ogp.png' ); ?>">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:image:alt" content="<?php echo esc_attr( $meta['image_alt'] ); ?>">
	<meta property="og:locale" content="ja_JP">
	<meta name="twitter:card" content="summary_large_image">
	<?php
}
add_action( 'wp_head', 'aquros_output_meta', 1 );

/**
 * ファビコン（管理画面の「サイトアイコン」が未設定のときだけテーマの画像を使う）
 */
function aquros_output_favicon() {
	if ( has_site_icon() ) {
		return;
	}
	?>
	<link rel="icon" href="<?php aquros_asset( 'images/favicon.svg' ); ?>" type="image/svg+xml">
	<link rel="icon" href="<?php aquros_asset( 'images/favicon-32.png' ); ?>" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="<?php aquros_asset( 'images/apple-touch-icon.png' ); ?>">
	<?php
}
add_action( 'wp_head', 'aquros_output_favicon', 2 );

/**
 * 連絡先の設定（外観 > カスタマイズ > AQUROS 連絡先）
 *
 * @param WP_Customize_Manager $wp_customize カスタマイザー。
 */
function aquros_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'aquros_contact',
		array(
			'title'    => 'AQUROS 連絡先',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'aquros_line_url',
		array(
			'default'           => 'https://lin.ee/XXXXXXX',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'aquros_line_url',
		array(
			'label'       => 'LINE 友だち追加URL',
			'description' => 'ページ内のLINEボタンすべてに使われます',
			'section'     => 'aquros_contact',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'aquros_line_qr',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'aquros_line_qr',
			array(
				'label'     => 'LINE QRコード画像',
				'section'   => 'aquros_contact',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'aquros_tel',
		array(
			'default'           => '047-710-5042',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'aquros_tel',
		array(
			'label'   => '電話番号',
			'section' => 'aquros_contact',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'aquros_customize_register' );

/**
 * LINE 友だち追加URL
 */
function aquros_line_url() {
	return get_theme_mod( 'aquros_line_url', 'https://lin.ee/XXXXXXX' );
}

/**
 * 電話番号（表示用）
 */
function aquros_tel() {
	return get_theme_mod( 'aquros_tel', '047-710-5042' );
}

/**
 * 電話番号（tel:リンク用）
 */
function aquros_tel_href() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', aquros_tel() );
}

/**
 * カスタム投稿「施工事例」
 */
function aquros_register_post_types() {
	register_post_type(
		'works',
		array(
			'labels'        => array(
				'name'                  => '施工事例',
				'singular_name'         => '施工事例',
				'add_new'               => '新規追加',
				'add_new_item'          => '施工事例を追加',
				'edit_item'             => '施工事例を編集',
				'all_items'             => '施工事例一覧',
				'search_items'          => '施工事例を検索',
				'not_found'             => '施工事例はまだありません',
				'featured_image'        => '施工写真',
				'set_featured_image'    => '施工写真を設定',
				'remove_featured_image' => '施工写真を削除',
				'use_featured_image'    => '施工写真として使用',
			),
			'description'   => 'トップページの「施工事例」に表示されます。タイトルが工事名になります。',
			// 一覧・詳細ページは作らず、トップページのカルーセルにだけ表示する
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => true,
			'menu_position' => 5,
			'menu_icon'     => 'dashicons-hammer',
			'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'aquros_register_post_types' );

/**
 * 施工事例の入力欄（ACF）
 *
 * ACFが無効でも表示が崩れないよう、値の取得は aquros_field() を通す。
 */
function aquros_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	acf_add_local_field_group(
		array(
			'key'      => 'group_aquros_works',
			'title'    => '施工事例の情報',
			'fields'   => array(
				array(
					'key'          => 'field_aquros_works_area',
					'label'        => '地域',
					'name'         => 'works_area',
					'type'         => 'text',
					'instructions' => '例：松戸市',
				),
				array(
					'key'          => 'field_aquros_works_period',
					'label'        => '工期',
					'name'         => 'works_period',
					'type'         => 'text',
					'instructions' => '例：2日',
				),
				array(
					'key'          => 'field_aquros_works_cost',
					'label'        => '費用',
					'name'         => 'works_cost',
					'type'         => 'text',
					'instructions' => '例：45万円（税込）',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'works',
					),
				),
			),
			'position' => 'acf_after_title',
		)
	);
}
add_action( 'acf/include_fields', 'aquros_register_fields' );

/**
 * カスタムフィールドの値
 *
 * @param string   $name    フィールド名。
 * @param int|null $post_id 投稿ID（省略時は現在の投稿）。
 */
function aquros_field( $name, $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$value   = function_exists( 'get_field' ) ? get_field( $name, $post_id ) : get_post_meta( $post_id, $name, true );
	return is_string( $value ) ? $value : '';
}

/**
 * トップページに出す施工事例（ヘッダーのメニューとセクションで同じ結果を使う）
 */
function aquros_works_query() {
	static $query = null;
	if ( null === $query ) {
		$query = new WP_Query(
			array(
				'post_type'      => 'works',
				'posts_per_page' => 12,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
				'no_found_rows'  => true,
			)
		);
	}
	return $query;
}
