<?php
/**
 * Default page template (About, etc.).
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
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
