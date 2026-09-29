<?php
/**
 * Small admin UX helpers.
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post types that rely on manual ordering (menu_order) to control the
 * front-end display order of plan cards / menu rows / work items.
 */
function mitsu_orderable_post_types() {
	return array( 'mitsu_service_plan', 'mitsu_menu_row', 'mitsu_work', 'mitsu_recruit' );
}

/**
 * Nudge editors toward the "並び順" (menu_order) field, and mention the
 * optional drag-and-drop plugin, on the relevant list screens.
 */
function mitsu_order_admin_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'edit' !== $screen->base || ! in_array( $screen->post_type, mitsu_orderable_post_types(), true ) ) {
		return;
	}
	echo '<div class="notice notice-info"><p>' . esc_html__(
		'表示順は各項目の編集画面右側「ページ属性」の並び順（数字が小さいほど先頭）で管理します。ドラッグ&ドロップで並び替えたい場合は無料プラグイン「Intuitive Custom Post Order」の導入をおすすめします。',
		'mitsumaru'
	) . '</p></div>';
}
add_action( 'admin_notices', 'mitsu_order_admin_notice' );

