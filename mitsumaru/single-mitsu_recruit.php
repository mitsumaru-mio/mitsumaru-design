<?php
/**
 * Single recruitment listing detail.
 *
 * @package mitsumaru
 */

get_header();
?>

<section class="page-content">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="news-teaser__thumb" style="margin-bottom:30px;max-width:600px;">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<?php $employment = get_field( 'recruit_employment_type' ); ?>
				<?php if ( $employment ) : ?>
					<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '雇用形態', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $employment ); ?></span></p>
				<?php endif; ?>

				<?php $salary = get_field( 'recruit_salary' ); ?>
				<?php if ( $salary ) : ?>
					<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '給与', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $salary ); ?></span></p>
				<?php endif; ?>

				<?php $summary = get_field( 'recruit_summary' ); ?>
				<?php if ( $summary ) : ?>
					<p><?php echo nl2br( esc_html( $summary ) ); ?></p>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>

			<p><a href="<?php echo esc_url( get_post_type_archive_link( 'mitsu_recruit' ) ); ?>">&laquo; <?php esc_html_e( '採用情報一覧へ戻る', 'mitsumaru' ); ?></a></p>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
