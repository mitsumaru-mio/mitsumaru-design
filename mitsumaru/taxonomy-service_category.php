<?php
/**
 * Service category archive: 「◯◯ プランメニュー」+ プランカード群 + 制作メニュー表。
 *
 * @package mitsumaru
 */

get_header();

$term = get_queried_object();

$plans_query = new WP_Query( array(
	'post_type'      => 'mitsu_service_plan',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
	'tax_query'      => array( array(
		'taxonomy' => 'service_category',
		'field'    => 'term_id',
		'terms'    => $term->term_id,
	) ),
) );

$menu_rows_query = new WP_Query( array(
	'post_type'      => 'mitsu_menu_row',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
	'tax_query'      => array( array(
		'taxonomy' => 'service_category',
		'field'    => 'term_id',
		'terms'    => $term->term_id,
	) ),
) );
?>

<section class="hero">
	<h1 class="hero__word">mitsumaru</h1>
</section>

<section class="page-content">
	<div class="container">
		<h2 class="section-title">
			<span class="section-title__circle" aria-hidden="true"></span>
			<span class="section-title__text"><?php esc_html_e( 'Service', 'mitsumaru' ); ?></span>
			<span class="section-title__circle" aria-hidden="true"></span>
		</h2>

		<h3 class="section-title--rule"><span><?php echo esc_html( $term->name ); ?> <?php esc_html_e( 'プランメニュー', 'mitsumaru' ); ?></span></h3>

		<?php $intro = mitsu_get_term_field( 'service_intro_text', $term ); ?>
		<?php if ( $intro ) : ?>
			<div class="service-intro"><?php echo wpautop( esc_html( $intro ) ); ?></div>
		<?php endif; ?>

		<?php $menu_items = mitsu_get_term_lines( 'service_menu_items', $term ); ?>
		<?php if ( $menu_items ) : ?>
			<ul class="service-menu-list">
				<?php foreach ( $menu_items as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $plans_query->have_posts() ) : ?>
			<?php $plan_index = 0; ?>
			<?php foreach ( $plans_query->posts as $plan ) : ?>
				<?php get_template_part( 'template-parts/service/plan-card', null, array( 'plan' => $plan, 'plan_index' => $plan_index ) ); ?>
				<?php $plan_index++; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ( $menu_rows_query->have_posts() ) : ?>
			<?php
			// Rows are split into one table per distinct "menu_row_group" value
			// (empty group = the default single table), so one category can
			// hold several differently-labelled tables (e.g. 動画編集 vs 月額プラン).
			$menu_groups = array();
			foreach ( $menu_rows_query->posts as $row ) {
				$group_raw = (string) get_field( 'menu_row_group', $row->ID );
				if ( ! isset( $menu_groups[ $group_raw ] ) ) {
					$menu_groups[ $group_raw ] = array();
				}
				$menu_groups[ $group_raw ][] = $row;
			}
			?>
			<?php foreach ( $menu_groups as $group_raw => $group_rows ) : ?>
				<?php get_template_part( 'template-parts/service/menu-table', null, array( 'term' => $term, 'rows' => $group_rows, 'group_raw' => $group_raw ) ); ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php
		$included_list = mitsu_get_term_lines( 'category_included_list', $term );
		$excluded_list = mitsu_get_term_lines( 'category_excluded_list', $term );
		?>
		<?php if ( $included_list || $excluded_list ) : ?>
			<div class="menu-notes">
				<?php if ( $included_list ) : ?>
					<div class="menu-notes__col">
						<h4><?php esc_html_e( '基本料金に含まれるもの', 'mitsumaru' ); ?></h4>
						<ul class="plan-card__list">
							<?php foreach ( $included_list as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if ( $excluded_list ) : ?>
					<div class="menu-notes__col">
						<h4><?php esc_html_e( '別途費用となるもの', 'mitsumaru' ); ?></h4>
						<ul class="plan-card__list">
							<?php foreach ( $excluded_list as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
	</div>
</section>

<?php get_footer(); ?>
