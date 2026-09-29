<?php
/**
 * Custom Post Types & Taxonomies.
 *
 * Content model:
 * - mitsu_news         : News (公開URLあり / archive: /news/)
 * - mitsu_work         : Works実績 (公開URLあり / archive: /works/) + タクソノミー work_category
 * - mitsu_recruit      : 採用情報 (公開URLあり / archive: /recruit/) + タクソノミー recruit_category
 * - mitsu_service_plan : Serviceページに埋め込む「料金プランカード」(非公開URL・管理画面のみ) + タクソノミー service_category
 * - mitsu_menu_row     : Serviceページの「制作メニュー表」の行 (非公開URL・管理画面のみ) + タクソノミー service_category
 *
 * mitsu_service_plan / mitsu_menu_row はフロントの単独ページを持たず、
 * taxonomy-service_category.php アーカイブテンプレートの中だけに表示されます。
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register post types.
 */
function mitsu_register_post_types() {

	register_post_type( 'mitsu_news', array(
		'labels'        => array(
			'name'          => __( 'News', 'mitsumaru' ),
			'singular_name' => __( 'News', 'mitsumaru' ),
			'add_new_item'  => __( 'Newsを追加', 'mitsumaru' ),
			'edit_item'     => __( 'Newsを編集', 'mitsumaru' ),
		),
		'public'        => true,
		'has_archive'   => 'news',
		'rewrite'       => array( 'slug' => 'news', 'with_front' => false ),
		'menu_icon'     => 'dashicons-megaphone',
		'menu_position' => 20,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'show_in_rest'  => true,
	) );

	register_post_type( 'mitsu_work', array(
		'labels'        => array(
			'name'          => __( 'Works', 'mitsumaru' ),
			'singular_name' => __( 'Work', 'mitsumaru' ),
			'add_new_item'  => __( 'Worksを追加', 'mitsumaru' ),
			'edit_item'     => __( 'Worksを編集', 'mitsumaru' ),
		),
		'public'        => true,
		'has_archive'   => 'works',
		'rewrite'       => array( 'slug' => 'works', 'with_front' => false ),
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
		'show_in_rest'  => true,
	) );

	register_post_type( 'mitsu_recruit', array(
		'labels'        => array(
			'name'          => __( 'Recruitment', 'mitsumaru' ),
			'singular_name' => __( 'Recruitment', 'mitsumaru' ),
			'add_new_item'  => __( '採用情報を追加', 'mitsumaru' ),
			'edit_item'     => __( '採用情報を編集', 'mitsumaru' ),
		),
		'public'        => true,
		'has_archive'   => 'recruit',
		'rewrite'       => array( 'slug' => 'recruit', 'with_front' => false ),
		'menu_icon'     => 'dashicons-groups',
		'menu_position' => 22,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
		'show_in_rest'  => true,
	) );

	// Service plan card. No public single page.
	register_post_type( 'mitsu_service_plan', array(
		'labels'        => array(
			'name'          => __( 'Service：料金プラン', 'mitsumaru' ),
			'singular_name' => __( '料金プラン', 'mitsumaru' ),
			'add_new_item'  => __( 'プランを追加', 'mitsumaru' ),
			'edit_item'     => __( 'プランを編集', 'mitsumaru' ),
		),
		'public'              => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-money-alt',
		'menu_position'       => 23,
		'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
		'show_in_rest'        => false,
	) );

	// Service menu table row. No public single page.
	register_post_type( 'mitsu_menu_row', array(
		'labels'        => array(
			'name'          => __( 'Service：制作メニュー表', 'mitsumaru' ),
			'singular_name' => __( 'メニュー行', 'mitsumaru' ),
			'add_new_item'  => __( 'メニュー行を追加', 'mitsumaru' ),
			'edit_item'     => __( 'メニュー行を編集', 'mitsumaru' ),
		),
		'public'              => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-editor-table',
		'menu_position'       => 24,
		'supports'            => array( 'title', 'page-attributes' ),
		'show_in_rest'        => false,
	) );
}
add_action( 'init', 'mitsu_register_post_types' );

/**
 * Register taxonomies.
 */
function mitsu_register_taxonomies() {

	register_taxonomy( 'service_category', array( 'mitsu_service_plan', 'mitsu_menu_row' ), array(
		'labels'       => array(
			'name'          => __( 'サービスカテゴリ', 'mitsumaru' ),
			'singular_name' => __( 'サービスカテゴリ', 'mitsumaru' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'rewrite'      => array( 'slug' => 'service' ),
		'show_in_rest' => true,
	) );

	register_taxonomy( 'work_category', array( 'mitsu_work' ), array(
		'labels'       => array(
			'name'          => __( 'Worksカテゴリ', 'mitsumaru' ),
			'singular_name' => __( 'Worksカテゴリ', 'mitsumaru' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'rewrite'      => array( 'slug' => 'works-category' ),
		'show_in_rest' => true,
	) );

	register_taxonomy( 'recruit_category', array( 'mitsu_recruit' ), array(
		'labels'       => array(
			'name'          => __( '採用カテゴリ', 'mitsumaru' ),
			'singular_name' => __( '採用カテゴリ', 'mitsumaru' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'rewrite'      => array( 'slug' => 'recruit-category' ),
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'mitsu_register_taxonomies' );

/**
 * Seed default taxonomy terms on theme activation so the footer /
 * navigation links exist immediately (Web / Motion / Paper media / Animation).
 */
function mitsu_seed_default_terms() {
	$map = array(
		'service_category' => array(
			'Web'              => 'web',
			'Landing page'     => 'landing-page',
			'Motion'           => 'motion',
			'Paper media'      => 'paper-media',
			'SNS・広告'          => 'sns-ad',
			'保守・運用'           => 'maintenance',
			'セットプラン'          => 'set-plans',
		),
		'work_category'     => array( 'Web' => 'web', 'Motion' => 'motion', 'Paper media' => 'paper-media' ),
		'recruit_category'  => array( 'Web' => 'web', 'Motion' => 'motion', 'Paper media' => 'paper-media', 'Animation' => 'animation' ),
	);

	foreach ( $map as $taxonomy => $terms ) {
		foreach ( $terms as $name => $slug ) {
			if ( ! term_exists( $slug, $taxonomy ) ) {
				wp_insert_term( $name, $taxonomy, array( 'slug' => $slug ) );
			}
		}
	}
}
add_action( 'after_switch_theme', function() {
	mitsu_register_post_types();
	mitsu_register_taxonomies();
	mitsu_seed_default_terms();
	flush_rewrite_rules();
} );

/**
 * Flush rewrite rules once if the CPTs were just registered but rules
 * are stale (e.g. after moving the theme between environments).
 */
function mitsu_maybe_flush_rewrites() {
	if ( ! get_option( 'mitsu_rewrite_flushed' ) ) {
		flush_rewrite_rules();
		update_option( 'mitsu_rewrite_flushed', 1 );
	}
}
add_action( 'init', 'mitsu_maybe_flush_rewrites', 20 );

/**
 * Front-end listing sizes, matched to the design mock-ups
 * (News: 10 rows / page, Works: a 3x3 grid / page).
 */
function mitsu_archive_query_vars( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_post_type_archive( 'mitsu_news' ) ) {
		$query->set( 'posts_per_page', 10 );
	}

	if ( $query->is_post_type_archive( 'mitsu_work' ) || $query->is_tax( 'work_category' ) ) {
		$query->set( 'posts_per_page', 9 );
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
	}

	if ( $query->is_post_type_archive( 'mitsu_recruit' ) || $query->is_tax( 'recruit_category' ) ) {
		$query->set( 'posts_per_page', 9 );
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'mitsu_archive_query_vars' );

/**
 * Admin list-table columns for quicker content management.
 */
function mitsu_work_admin_columns( $columns ) {
	$columns['work_period'] = __( '制作期間', 'mitsumaru' );
	$columns['work_price']  = __( '料金', 'mitsumaru' );
	return $columns;
}
add_filter( 'manage_mitsu_work_posts_columns', 'mitsu_work_admin_columns' );

function mitsu_work_admin_column_content( $column, $post_id ) {
	if ( 'work_period' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'work_period', true ) );
	}
	if ( 'work_price' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'work_price', true ) );
	}
}
add_action( 'manage_mitsu_work_posts_custom_column', 'mitsu_work_admin_column_content', 10, 2 );

function mitsu_menu_row_admin_columns( $columns ) {
	$columns['menu_row_price'] = __( '料金', 'mitsumaru' );
	return $columns;
}
add_filter( 'manage_mitsu_menu_row_posts_columns', 'mitsu_menu_row_admin_columns' );

function mitsu_menu_row_admin_column_content( $column, $post_id ) {
	if ( 'menu_row_price' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'menu_row_price', true ) );
	}
}
add_action( 'manage_mitsu_menu_row_posts_custom_column', 'mitsu_menu_row_admin_column_content', 10, 2 );
