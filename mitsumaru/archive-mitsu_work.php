<?php
/**
 * Works archive: 3x3 arch-card grid, paginated.
 *
 * @package mitsumaru
 */

get_header();
?>

<section class="hero">
	<h1 class="hero__word">mitsumaru</h1>
</section>

<section class="page-content">
	<div class="container">
		<h2 class="section-title">
			<span class="section-title__circle" aria-hidden="true"></span>
			<span class="section-title__text"><?php esc_html_e( 'Works', 'mitsumaru' ); ?></span>
			<span class="section-title__circle" aria-hidden="true"></span>
		</h2>

		<?php if ( have_posts() ) : ?>
			<div class="works-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/works/work-card' ); ?>
				<?php endwhile; ?>
			</div>

			<?php mitsu_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( '現在掲載中の実績はありません。', 'mitsumaru' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
