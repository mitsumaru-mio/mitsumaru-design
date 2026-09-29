<?php
/**
 * "制作メニュー" price table for a Service category.
 *
 * A category can be split into several tables via each row's
 * "menu_row_group" field; group_raw carries that row's raw value along
 * ("グループ名 | 料金列見出し | 追加料金列見出し") so this table can override
 * its own heading/labels instead of the category-wide defaults.
 *
 * Passed via get_template_part()'s $args:
 * @var WP_Term   $term
 * @var WP_Post[] $rows      Posts of type mitsu_menu_row already queried for this term/group.
 * @var string    $group_raw Raw "menu_row_group" value shared by these rows.
 *
 * @package mitsumaru
 */

if ( empty( $args['term'] ) || empty( $args['rows'] ) ) {
	return;
}

$term      = $args['term'];
$rows      = $args['rows'];
$group_raw = isset( $args['group_raw'] ) ? $args['group_raw'] : '';

$group_parts = $group_raw ? array_map( 'trim', explode( '|', $group_raw ) ) : array();

$is_dark = mitsu_get_term_field( 'menu_table_dark', $term );

$heading = ! empty( $group_parts[0] ) ? $group_parts[0] : mitsu_get_term_field( 'menu_table_heading', $term );
$heading = $heading ? $heading : $term->name . __( '制作メニュー', 'mitsumaru' );

$price_label = ! empty( $group_parts[1] ) ? $group_parts[1] : mitsu_get_term_field( 'menu_table_price_label', $term );
$price_label = $price_label ? $price_label : __( '料金', 'mitsumaru' );

$extra_label = ! empty( $group_parts[2] ) ? $group_parts[2] : mitsu_get_term_field( 'menu_table_extra_label', $term );
$extra_label = $extra_label ? $extra_label : __( '追加料金', 'mitsumaru' );

// The 3rd column (追加料金 / 内容 etc.) is only shown when at least one row uses it,
// so 2-column price tables (the common case) don't need an empty column entered.
$has_extra = false;
foreach ( $rows as $row ) {
	if ( get_field( 'menu_row_extra', $row->ID ) ) {
		$has_extra = true;
		break;
	}
}
?>
<div class="menu-table-wrap">
	<h3 class="section-title--rule"><span><?php echo esc_html( $heading ); ?></span></h3>

	<table class="menu-table<?php echo $is_dark ? ' menu-table--dark' : ''; ?>">
		<thead>
			<tr>
				<th><?php esc_html_e( '項目', 'mitsumaru' ); ?></th>
				<th><?php echo esc_html( $price_label ); ?></th>
				<?php if ( $has_extra ) : ?>
					<th><?php echo esc_html( $extra_label ); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $rows as $row ) : ?>
				<tr>
					<td><?php echo esc_html( get_the_title( $row ) ); ?></td>
					<td><?php echo esc_html( get_field( 'menu_row_price', $row->ID ) ); ?></td>
					<?php if ( $has_extra ) : ?>
						<td><?php echo esc_html( get_field( 'menu_row_extra', $row->ID ) ); ?></td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
