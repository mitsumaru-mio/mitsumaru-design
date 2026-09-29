<?php
/**
 * Reusable template helpers.
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inline chevron SVG (used for pagination + news carousel arrows).
 *
 * @param string $dir 'left'|'right'.
 */
function mitsu_chevron_svg( $dir = 'right' ) {
	$path = 'left' === $dir ? 'M14 5l-7 7 7 7' : 'M10 5l7 7-7 7';
	return '<svg width="10" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="' . esc_attr( $path ) . '" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

/**
 * Circular numbered pagination, styled to match the design mock-ups.
 *
 * @param array $args Optional overrides passed to paginate_links().
 */
function mitsu_pagination( $args = array() ) {
	global $wp_query;

	$defaults = array(
		'total'     => isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1,
		'current'   => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
		'mid_size'  => 1,
		'prev_next' => true,
		'prev_text' => mitsu_chevron_svg( 'left' ),
		'next_text' => mitsu_chevron_svg( 'right' ),
		'type'      => 'array',
	);

	$args  = wp_parse_args( $args, $defaults );
	$links = paginate_links( $args );

	if ( empty( $links ) ) {
		return;
	}

	echo '<nav class="pagination" aria-label="' . esc_attr__( 'ページ送り', 'mitsumaru' ) . '">';
	foreach ( $links as $link ) {
		echo wp_kses_post( $link );
	}
	echo '</nav>';
}

/**
 * Parse the pipe-delimited "price breakdown" textarea into rows.
 * Format per line: "Label | Price".
 *
 * @param int $post_id
 * @return array[] List of [ 'label' => string, 'price' => string ].
 */
function mitsu_get_price_rows( $post_id ) {
	$raw = get_field( 'plan_price_breakdown', $post_id );
	if ( empty( $raw ) ) {
		return array();
	}

	$rows = array();
	foreach ( preg_split( "/\r\n|\r|\n/", $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$rows[] = array(
			'label' => $parts[0],
			'price' => isset( $parts[1] ) ? $parts[1] : '',
		);
	}
	return $rows;
}

/**
 * Read an ACF field attached to a taxonomy term (ACF expects the post_id
 * argument formatted as "{$taxonomy}_{$term_id}" for term locations).
 *
 * @param string  $field
 * @param WP_Term $term
 * @return mixed
 */
function mitsu_get_term_field( $field, $term ) {
	if ( ! function_exists( 'get_field' ) || ! $term instanceof WP_Term ) {
		return null;
	}
	return get_field( $field, $term->taxonomy . '_' . $term->term_id );
}

/**
 * Split a newline-separated ACF textarea field into a trimmed, non-empty
 * list of lines. Used for the various "1行につき1項目" bullet-list fields
 * (plan_features, plan_recommended, service_menu_items, ...).
 *
 * @param int    $post_id
 * @param string $field_name
 * @return string[]
 */
function mitsu_get_lines( $post_id, $field_name ) {
	$raw = get_field( $field_name, $post_id );
	if ( empty( $raw ) ) {
		return array();
	}

	$lines = array();
	foreach ( preg_split( "/\r\n|\r|\n/", $raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$lines[] = $line;
		}
	}
	return $lines;
}

/**
 * Same as mitsu_get_lines(), for a field attached to a taxonomy term.
 *
 * @param string  $field_name
 * @param WP_Term $term
 * @return string[]
 */
function mitsu_get_term_lines( $field_name, $term ) {
	$raw = mitsu_get_term_field( $field_name, $term );
	if ( empty( $raw ) ) {
		return array();
	}

	$lines = array();
	foreach ( preg_split( "/\r\n|\r|\n/", $raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$lines[] = $line;
		}
	}
	return $lines;
}

/**
 * Get terms for a footer navigation column, ordered by name.
 *
 * @param string $taxonomy
 * @return WP_Term[]
 */
function mitsu_footer_terms( $taxonomy ) {
	$terms = get_terms( array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
		'orderby'    => 'term_order',
		'order'      => 'ASC',
	) );
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * URL of the "About" page, if the editor created one with slug `about`.
 *
 * @return string
 */
function mitsu_about_page_url() {
	$page = get_page_by_path( 'about' );
	return $page ? get_permalink( $page ) : '#';
}

/**
 * Fallback nav shown until an admin assigns a menu under
 * 外観 > メニュー (Appearance > Menus).
 */
function mitsu_primary_nav_fallback() {
	$items = array(
		'news'    => array( __( 'News', 'mitsumaru' ), home_url( '/news/' ) ),
		'service' => array( __( 'Service', 'mitsumaru' ), home_url( '/service/web/' ) ),
		'works'   => array( __( 'Works', 'mitsumaru' ), home_url( '/works/' ) ),
		'recruit' => array( __( 'Recruitment', 'mitsumaru' ), home_url( '/recruit/' ) ),
		'contact' => array( __( 'Contact', 'mitsumaru' ), home_url( '/contact/' ) ),
	);
	echo '<ul>';
	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item[1] ), esc_html( $item[0] ) );
	}
	echo '</ul>';
}

/**
 * Latest N news posts for the footer column.
 *
 * @param int $count
 * @return WP_Post[]
 */
function mitsu_latest_news( $count = 3 ) {
	$query = new WP_Query( array(
		'post_type'      => 'mitsu_news',
		'posts_per_page' => $count,
		'no_found_rows'  => true,
	) );
	return $query->posts;
}
