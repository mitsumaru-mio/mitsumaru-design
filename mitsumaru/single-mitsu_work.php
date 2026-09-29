<?php
/**
 * Single Work detail page.
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

				<?php $period = get_field( 'work_period' ); ?>
				<?php if ( $period ) : ?>
					<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '制作期間', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $period ); ?></span></p>
				<?php endif; ?>

				<?php $price = get_field( 'work_price' ); ?>
				<?php if ( $price ) : ?>
					<p class="work-card__row"><span class="work-card__row-label"><?php esc_html_e( '料金', 'mitsumaru' ); ?></span><span>：<?php echo esc_html( $price ); ?></span></p>
				<?php endif; ?>

				<?php $url = get_field( 'work_url' ); ?>
				<?php if ( $url ) : ?>
					<p><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'サイトを見る', 'mitsumaru' ); ?> &raquo;</a></p>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>

			<p><a href="<?php echo esc_url( get_post_type_archive_link( 'mitsu_work' ) ); ?>">&laquo; <?php esc_html_e( 'Works一覧へ戻る', 'mitsumaru' ); ?></a></p>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
