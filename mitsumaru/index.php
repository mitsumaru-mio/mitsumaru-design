<?php
/**
 * Fallback template (required by WordPress; rarely hit directly since
 * front-page.php / archive-*.php / single-*.php / page.php cover every
 * URL this theme generates).
 *
 * @package mitsumaru
 */

get_header();
?>

<section class="page-content">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>

			<?php mitsu_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'コンテンツが見つかりませんでした。', 'mitsumaru' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
