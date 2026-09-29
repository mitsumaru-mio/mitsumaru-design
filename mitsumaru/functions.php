<?php
/**
 * mitsumaru design theme bootstrap
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MITSU_VERSION', '1.0.0' );
define( 'MITSU_DIR', get_template_directory() );
define( 'MITSU_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function mitsu_setup() {
	load_theme_textdomain( 'mitsumaru', MITSU_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __( 'メインナビゲーション', 'mitsumaru' ),
		'offcanvas' => __( 'オフキャンバスメニュー', 'mitsumaru' ),
	) );

	set_post_thumbnail_size( 800, 600, true );
}
add_action( 'after_setup_theme', 'mitsu_setup' );

/**
 * Enqueue styles & scripts.
 */
function mitsu_assets() {
	// 見出し・ロゴ・価格表示用の "century-gothic"(Century Gothic Pro) は
	// Adobe Fonts(Typekit) の埋め込みキット経由で読み込みます。
	// キットIDは外観 > カスタマイズ > フォント設定 で変更できます(既定値は旧サイトと同じ sjv5unx)。
	$typekit_id = mitsu_get_option( 'mitsu_typekit_id', 'sjv5unx' );
	if ( $typekit_id ) {
		wp_enqueue_style( 'mitsu-typekit', 'https://use.typekit.net/' . rawurlencode( $typekit_id ) . '.css', array(), null );
	}

	// 本文用 Noto Sans JP と、ページ送り数字専用の Zen Maru Gothic はGoogle Fonts。
	wp_enqueue_style( 'mitsu-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&family=Zen+Maru+Gothic:wght@500;700&display=swap', array(), null );
	wp_enqueue_style( 'mitsu-style', get_stylesheet_uri(), array(), MITSU_VERSION );
	wp_enqueue_script( 'mitsu-main', MITSU_URI . '/assets/js/main.js', array(), MITSU_VERSION, true );

	if ( is_singular() ) {
		wp_enqueue_script( 'wp-embed' );
	}
}
add_action( 'wp_enqueue_scripts', 'mitsu_assets' );

/**
 * Widget area (footer columns are hard-coded from CPT/taxonomy data,
 * but an extra widget area is provided for flexibility).
 */
function mitsu_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'ページサイドバー', 'mitsumaru' ),
		'id'            => 'sidebar-page',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'mitsu_widgets_init' );

/**
 * Includes.
 */
require MITSU_DIR . '/inc/custom-post-types.php';
require MITSU_DIR . '/inc/acf-fields.php';
require MITSU_DIR . '/inc/template-tags.php';
require MITSU_DIR . '/inc/customizer.php';
require MITSU_DIR . '/inc/analytics.php';
require MITSU_DIR . '/inc/contact-form.php';
require MITSU_DIR . '/inc/admin.php';

/**
 * Sensible defaults: disable comments site-wide (this theme has no
 * comment-driven templates) to reduce spam-management overhead.
 */
function mitsu_disable_comments_support() {
	$post_types = get_post_types();
	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'init', 'mitsu_disable_comments_support', 100 );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
