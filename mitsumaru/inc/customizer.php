<?php
/**
 * Theme Customizer: site-wide settings that don't belong to any single
 * piece of content (social links, footer text, contact recipient).
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mitsu_customize_register( $wp_customize ) {

	$wp_customize->add_section( 'mitsu_social', array(
		'title'    => __( 'ソーシャルリンク', 'mitsumaru' ),
		'priority' => 120,
	) );

	$socials = array(
		'instagram' => 'Instagram URL',
		'twitter'   => 'X (Twitter) URL',
		'facebook'  => 'Facebook URL',
	);

	foreach ( $socials as $key => $label ) {
		$setting = 'mitsu_social_' . $key;
		$wp_customize->add_setting( $setting, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( $setting, array(
			'label'   => $label,
			'section' => 'mitsu_social',
			'type'    => 'url',
		) );
	}

	$wp_customize->add_section( 'mitsu_font', array(
		'title'    => __( 'フォント設定', 'mitsumaru' ),
		'priority' => 118,
	) );

	$wp_customize->add_setting( 'mitsu_typekit_id', array(
		'default'           => 'sjv5unx',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mitsu_typekit_id', array(
		'label'       => __( 'Adobe Fonts(Typekit) キットID', 'mitsumaru' ),
		'description' => __( '見出し・ロゴ・価格に使う「Century Gothic Pro」を読み込むためのAdobe Fontsキット埋め込みコードID(例: sjv5unx)。Adobe Fontsアカウントが失効した場合は空欄にすると代替の游ゴシック等にフォールバックします。', 'mitsumaru' ),
		'section'     => 'mitsu_font',
		'type'        => 'text',
	) );

	$wp_customize->add_section( 'mitsu_hero', array(
		'title'    => __( 'トップページ ヒーロー', 'mitsumaru' ),
		'priority' => 119,
	) );

	$wp_customize->add_setting( 'mitsu_hero_word', array(
		'default'           => 'mitsumaru',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mitsu_hero_word', array(
		'label'   => __( 'ヒーローの大見出し文字', 'mitsumaru' ),
		'section' => 'mitsu_hero',
		'type'    => 'text',
	) );

	$wp_customize->add_section( 'mitsu_footer', array(
		'title'    => __( 'フッター設定', 'mitsumaru' ),
		'priority' => 121,
	) );

	$wp_customize->add_setting( 'mitsu_copyright_text', array(
		'default'           => 'copyright © mitsumaru design',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mitsu_copyright_text', array(
		'label'   => __( 'コピーライト表記', 'mitsumaru' ),
		'section' => 'mitsu_footer',
		'type'    => 'text',
	) );

	$wp_customize->add_section( 'mitsu_analytics', array(
		'title'    => __( 'アクセス解析', 'mitsumaru' ),
		'priority' => 123,
	) );

	$wp_customize->add_setting( 'mitsu_ga_measurement_id', array(
		'default'           => 'G-1QMZFGF2GD',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mitsu_ga_measurement_id', array(
		'label'       => __( 'Google アナリティクス 測定ID', 'mitsumaru' ),
		'description' => __( '例：G-XXXXXXXXXX。空欄にするとタグの出力を停止します。', 'mitsumaru' ),
		'section'     => 'mitsu_analytics',
		'type'        => 'text',
	) );

	$wp_customize->add_section( 'mitsu_contact', array(
		'title'    => __( 'お問い合わせ設定', 'mitsumaru' ),
		'priority' => 122,
	) );

	$wp_customize->add_setting( 'mitsu_contact_email', array(
		'default'           => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'mitsu_contact_email', array(
		'label'       => __( '問い合わせフォームの送信先メールアドレス', 'mitsumaru' ),
		'section'     => 'mitsu_contact',
		'type'        => 'email',
	) );
}
add_action( 'customize_register', 'mitsu_customize_register' );

/**
 * Convenience getter used in templates.
 */
function mitsu_get_option( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}
