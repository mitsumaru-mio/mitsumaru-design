<?php
/**
 * Single recruitment listing card.
 *
 * NOTE: no mock-up was supplied for the Recruitment page, so this reuses
 * the Works card layout for visual consistency. Adjust once a design exists.
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
			<?php $employment = get_field( 'recruit_employment_type' ); ?>
			<?php if ( $employment ) : ?>
				<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '雇用形態', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $employment ); ?></span></p>
			<?php endif; ?>
			<?php $salary = get_field( 'recruit_salary' ); ?>
			<?php if ( $salary ) : ?>
				<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '給与', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $salary ); ?></span></p>
			<?php endif; ?>
		</div>
	</a>
</article>
