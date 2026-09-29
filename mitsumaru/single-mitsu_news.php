<?php
/**
 * Single News post.
 *
 * @package mitsumaru
 */

get_header();
?>

<section class="page-content">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<p class="news-list__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="news-teaser__thumb" style="margin-bottom:30px;max-width:600px;">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>

			<p><a href="<?php echo esc_url( get_post_type_archive_link( 'mitsu_news' ) ); ?>">&laquo; <?php esc_html_e( 'News一覧へ戻る', 'mitsumaru' ); ?></a></p>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
