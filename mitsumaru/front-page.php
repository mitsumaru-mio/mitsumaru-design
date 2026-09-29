<?php
/**
 * Front page: hero wordmark + latest-News teaser carousel.
 *
 * @package mitsumaru
 */

get_header();

$news_items = mitsu_latest_news( 5 );
?>

<section class="hero">
	<h1 class="hero__word"><?php echo esc_html( mitsu_get_option( 'mitsu_hero_word', 'mitsumaru' ) ); ?></h1>
</section>

<?php if ( $news_items ) : ?>
<section class="news-teaser">
	<div class="container">
		<h2 class="section-title">
			<span class="section-title__circle" aria-hidden="true"></span>
			<span class="section-title__text"><?php esc_html_e( 'News', 'mitsumaru' ); ?></span>
			<span class="section-title__circle" aria-hidden="true"></span>
		</h2>

		<div class="news-teaser__slides" id="js-news-slides">
			<?php foreach ( $news_items as $index => $news_post ) : ?>
				<article class="news-teaser__slide<?php echo 0 === $index ? ' is-active' : ''; ?>">
					<div class="news-teaser__text">
						<p class="news-teaser__date"><?php echo esc_html( get_the_date( 'Y.m.d', $news_post ) ); ?></p>
						<div class="news-teaser__excerpt">
							<?php echo wp_kses_post( wpautop( get_the_content( null, false, $news_post ) ) ); ?>
						</div>
					</div>
					<div class="news-teaser__thumb">
						<?php if ( has_post_thumbnail( $news_post ) ) : ?>
							<?php echo get_the_post_thumbnail( $news_post, 'large' ); ?>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<?php if ( count( $news_items ) > 1 ) : ?>
			<div class="news-teaser__nav">
				<button type="button" id="js-news-prev" aria-label="<?php esc_attr_e( '前のNews', 'mitsumaru' ); ?>"><?php echo mitsu_chevron_svg( 'left' ); ?></button>
				<button type="button" id="js-news-next" aria-label="<?php esc_attr_e( '次のNews', 'mitsumaru' ); ?>"><?php echo mitsu_chevron_svg( 'right' ); ?></button>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
