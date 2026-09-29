<?php
/**
 * News archive: dashed-rule list, paginated 10/page.
 *
 * @package mitsumaru
 */

get_header();
?>

<section class="hero">
	<h1 class="hero__word">mitsumaru</h1>
</section>

<section class="news-list">
	<div class="container">
		<h2 class="section-title">
			<span class="section-title__circle" aria-hidden="true"></span>
			<span class="section-title__text"><?php esc_html_e( 'News', 'mitsumaru' ); ?></span>
			<span class="section-title__circle" aria-hidden="true"></span>
		</h2>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="news-list__item">
					<p class="news-list__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
					<div class="news-list__excerpt">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</div>
				</article>
			<?php endwhile; ?>

			<?php mitsu_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( '現在お知らせはありません。', 'mitsumaru' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
