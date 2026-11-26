<?php
/**
 * テーマ有効化時に入れる初期データ
 *
 * 静的版（index.html・privacy.html）と同じ内容をWordPressに登録する。
 *
 * @package aquros-lp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 施工事例の初期データ（静的版 index.html と同じ内容・同じ順番）
 *
 * キーは写真のファイル名。assets/images/works/ の「キー-before.jpg」「キー-after.jpg」を使う。
 * 地域・工期・ひとことは仮の内容（お客様に確認のうえ確定）。
 */
function aquros_initial_works() {
	return array(
		'toilet'         => array(
			'title'   => 'トイレの交換',
			'area'    => '松戸市',
			'period'  => '1日',
			'comment' => '節水型のトイレに替えて、毎日のお掃除も楽になりました。',
		),
		'washbasin'      => array(
			'title'   => '洗面台の交換',
			'area'    => '柏市',
			'period'  => '1日',
			'comment' => '収納が増えて、洗面まわりがすっきり片づきました。',
		),
		'shower-faucet'  => array(
			'title'   => '浴室のシャワー水栓の交換',
			'area'    => '松戸市',
			'period'  => '半日',
			'comment' => 'お湯の温度を合わせやすくなり、シャワーが快適になりました。',
		),
		'bathtub-faucet' => array(
			'title'   => '浴槽の水栓の交換',
			'area'    => '柏市',
			'period'  => '半日',
			'comment' => 'ポタポタと続いていた水漏れが止まり、安心してお使いいただけます。',
		),
		'water-heater'   => array(
			'title'   => '給湯器の交換',
			'area'    => '松戸市',
			'period'  => '1日',
			'comment' => 'お湯がすぐに出るようになり、冬のお風呂も快適です。',
		),
	);
}

/**
 * テーマ内の画像をメディアライブラリに登録する
 *
 * @param string $file    assets/images/ からの相対パス。
 * @param string $title   画像のタイトル。
 * @param int    $post_id 画像を紐づける投稿ID。
 * @return int 添付ファイルID（失敗したときは0）。
 */
function aquros_import_theme_image( $file, $title, $post_id ) {
	$path = get_theme_file_path( 'assets/images/' . $file );
	if ( ! file_exists( $path ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// media_handle_sideload は渡したファイルを移動するため、テーマ内の画像はコピーして渡す
	$tmp = wp_tempnam( basename( $path ) );
	if ( ! $tmp || ! copy( $path, $tmp ) ) {
		return 0;
	}
	$id = media_handle_sideload(
		array(
			'name'     => basename( $path ),
			'tmp_name' => $tmp,
		),
		$post_id,
		$title
	);
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	return $id;
}

/**
 * テーマ有効化時に、施工事例を写真付きで登録する
 *
 * 施工事例が1件もないときに一度だけ実行する。管理画面で事例を消したあとにテーマを有効化し直しても、
 * 消した事例が戻らないよう、実行済みの印を残す。
 */
function aquros_setup_initial_works() {
	if ( get_option( 'aquros_initial_works_done' ) ) {
		return;
	}
	$existing = get_posts(
		array(
			'post_type'   => 'works',
			'post_status' => 'any',
			'numberposts' => 1,
			'fields'      => 'ids',
		)
	);
	if ( $existing ) {
		update_option( 'aquros_initial_works_done', 1 );
		return;
	}

	$order = 0;
	foreach ( aquros_initial_works() as $key => $work ) {
		$title   = $work['title'];
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'works',
				'post_status' => 'publish',
				'post_title'  => $title,
				'menu_order'  => $order++,
			)
		);
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}
		foreach ( array( 'area', 'period', 'comment' ) as $field ) {
			update_post_meta( $post_id, "works_{$field}", $work[ $field ] );
			update_post_meta( $post_id, "_works_{$field}", "field_aquros_works_{$field}" );
		}
		foreach ( array(
			'before' => '施工前',
			'after'  => '施工後',
		) as $state => $label ) {
			$image_id = aquros_import_theme_image( "works/{$key}-{$state}.jpg", "{$title}（{$label}）", $post_id );
			if ( $image_id ) {
				update_post_meta( $post_id, "works_{$state}", $image_id );
				// ACFが値と入力欄を結びつけるための参照キー
				update_post_meta( $post_id, "_works_{$state}", "field_aquros_works_{$state}" );
			}
		}
	}
	update_option( 'aquros_initial_works_done', 1 );
}
add_action( 'after_switch_theme', 'aquros_setup_initial_works' );

/**
 * テーマ有効化時に、プライバシーポリシーのページを用意する
 *
 * 「設定 > プライバシー」のページが公開済みなら何もしない。WordPressが最初に作る下書きのままなら、
 * テーマの文面（inc/privacy-policy.html）で上書きして公開する。
 */
function aquros_setup_privacy_policy_page() {
	$page_id = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $page_id && 'publish' === get_post_status( $page_id ) ) {
		return;
	}

	$content = file_get_contents( get_theme_file_path( 'inc/privacy-policy.html' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( false === $content ) {
		return;
	}

	$page = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => 'プライバシーポリシー',
		'post_content' => $content,
	);
	if ( $page_id && get_post( $page_id ) ) {
		$page['ID'] = $page_id;
		$page_id    = wp_update_post( $page );
	} else {
		$page['post_name'] = 'privacy-policy';
		$page_id           = wp_insert_post( $page );
	}
	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_option( 'wp_page_for_privacy_policy', $page_id );
	}
}
add_action( 'after_switch_theme', 'aquros_setup_privacy_policy_page' );
