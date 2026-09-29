<?php
/**
 * 404 page.
 *
 * @package mitsumaru
 */

get_header();
?>

<section class="page-content">
	<div class="container" style="text-align:center;">
		<h1 class="entry-title">404</h1>
		<p><?php esc_html_e( 'お探しのページは見つかりませんでした。', 'mitsumaru' ); ?></p>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'トップページへ戻る', 'mitsumaru' ); ?></a></p>
	</div>
</section>

<?php get_footer(); ?>
