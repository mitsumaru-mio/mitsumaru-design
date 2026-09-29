<?php
/**
 * Single plan card inside a Service category archive.
 *
 * Passed via get_template_part()'s $args:
 * @var WP_Post $plan
 * @var int      $plan_index  0-based position, used to alternate the image side.
 *
 * @package mitsumaru
 */

if ( empty( $args['plan'] ) ) {
	return;
}

$plan       = $args['plan'];
$plan_index = isset( $args['plan_index'] ) ? (int) $args['plan_index'] : 0;

$side_class = ( 0 === $plan_index % 2 ) ? 'plan-card--media-left' : 'plan-card--media-right';
$rows       = mitsu_get_price_rows( $plan->ID );
?>
<div class="plan-card <?php echo esc_attr( $side_class ); ?>">
	<div class="plan-card__media">
		<?php if ( has_post_thumbnail( $plan ) ) : ?>
			<?php echo get_the_post_thumbnail( $plan, 'large' ); ?>
		<?php endif; ?>
	</div>
	<div class="plan-card__body">
		<h3 class="plan-card__title"><?php echo esc_html( get_the_title( $plan ) ); ?></h3>

		<?php $lead = get_field( 'plan_price_lead', $plan->ID ); ?>
		<?php if ( $lead ) : ?>
			<p class="plan-card__price-lead"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>

		<?php $desc = get_field( 'plan_description', $plan->ID ); ?>
		<?php if ( $desc ) : ?>
			<p class="plan-card__desc"><?php echo nl2br( esc_html( $desc ) ); ?></p>
		<?php endif; ?>

		<?php $recommended = mitsu_get_lines( $plan->ID, 'plan_recommended' ); ?>
		<?php if ( $recommended ) : ?>
			<p class="plan-card__list-heading plan-card__list-heading--recommended"><?php esc_html_e( 'おすすめの方', 'mitsumaru' ); ?></p>
			<ul class="plan-card__list plan-card__list--recommended">
				<?php foreach ( $recommended as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php $features = mitsu_get_lines( $plan->ID, 'plan_features' ); ?>
		<?php if ( $features ) : ?>
			<p class="plan-card__list-heading plan-card__list-heading--features"><?php esc_html_e( '内容', 'mitsumaru' ); ?></p>
			<ul class="plan-card__list plan-card__list--features">
				<?php foreach ( $features as $feature ) : ?>
					<li><?php echo esc_html( $feature ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $rows ) : ?>
			<div class="price-box">
				<?php foreach ( $rows as $row ) : ?>
					<div class="price-box__row">
						<span><?php echo esc_html( $row['label'] ); ?></span>
						<span><?php echo esc_html( $row['price'] ); ?></span>
					</div>
				<?php endforeach; ?>

				<?php $total = get_field( 'plan_total_price', $plan->ID ); ?>
				<?php if ( $total ) : ?>
					<div class="price-box__total">
						<span class="price-box__total-value"><?php echo esc_html( $total ); ?></span>
					</div>
				<?php endif; ?>

				<?php $note = get_field( 'plan_note', $plan->ID ); ?>
				<?php if ( $note ) : ?>
					<p class="price-box__note"><?php echo esc_html( $note ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
