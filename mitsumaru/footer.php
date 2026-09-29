<?php
/**
 * Footer: News / About / Service / Works / Recruitment columns + social + copyright bar.
 *
 * @package mitsumaru
 */
?>
</main>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">

			<div class="footer-col footer-col--news">
				<h3><?php esc_html_e( 'News', 'mitsumaru' ); ?></h3>
				<ul>
					<?php foreach ( mitsu_latest_news( 3 ) as $news_post ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $news_post ) ); ?>">
								<?php echo esc_html( get_the_date( 'Y.m.d', $news_post ) ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-col footer-col--about">
				<h3><?php esc_html_e( 'About', 'mitsumaru' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( mitsu_about_page_url() ); ?>"><?php esc_html_e( 'About', 'mitsumaru' ); ?></a></li>
				</ul>
			</div>

			<div class="footer-col footer-col--service">
				<h3><?php esc_html_e( 'Service', 'mitsumaru' ); ?></h3>
				<ul>
					<?php foreach ( mitsu_footer_terms( 'service_category' ) as $term ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-col footer-col--works">
				<h3><?php esc_html_e( 'Works', 'mitsumaru' ); ?></h3>
				<ul>
					<?php foreach ( mitsu_footer_terms( 'work_category' ) as $term ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-col footer-col--recruit">
				<h3><?php esc_html_e( 'Recruitment', 'mitsumaru' ); ?></h3>
				<ul>
					<?php foreach ( mitsu_footer_terms( 'recruit_category' ) as $term ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

		</div>

		<?php
		$socials = array(
			'instagram' => array( mitsu_get_option( 'mitsu_social_instagram' ), 'Instagram' ),
			'twitter'   => array( mitsu_get_option( 'mitsu_social_twitter' ), 'X (Twitter)' ),
			'facebook'  => array( mitsu_get_option( 'mitsu_social_facebook' ), 'Facebook' ),
		);
		?>
		<div class="footer-social">
			<?php foreach ( $socials as $key => $social ) : ?>
				<?php if ( ! empty( $social[0] ) ) : ?>
					<a href="<?php echo esc_url( $social[0] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social[1] ); ?>">
						<span class="icon icon--<?php echo esc_attr( $key ); ?>" aria-hidden="true"></span>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<p class="site-footer__bar"><?php echo esc_html( mitsu_get_option( 'mitsu_copyright_text', 'copyright © mitsumaru design' ) ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
