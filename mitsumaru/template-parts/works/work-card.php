<?php
/**
 * Single work item card for the Works grid (arch-shaped thumbnail).
 *
 * @package mitsumaru
 */
?>
<article class="work-card">
	<a href="<?php the_permalink(); ?>">
		<div class="work-card__thumb">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large' ); ?>
			<?php endif; ?>
		</div>
		<div class="work-card__meta">
			<h3 class="work-card__title"><?php the_title(); ?></h3>
			<?php $period = get_field( 'work_period' ); ?>
			<?php if ( $period ) : ?>
				<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '制作期間', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $period ); ?></span></p>
			<?php endif; ?>
			<?php $price = get_field( 'work_price' ); ?>
			<?php if ( $price ) : ?>
				<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '料金', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $price ); ?></span></p>
			<?php endif; ?>
		</div>
	</a>
</article>
