<?php
/**
 * Header: logo, primary nav, hamburger / off-canvas menu.
 *
 * @package mitsumaru
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="site-header__inner">
		<p class="site-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</p>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'メインナビゲーション', 'mitsumaru' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => 'mitsu_primary_nav_fallback',
			) );
			?>
		</nav>

		<button type="button" class="menu-toggle" id="js-menu-toggle" aria-expanded="false" aria-controls="js-offcanvas">
			<span></span><span></span><span></span>
			<span class="screen-reader-text"><?php esc_html_e( 'メニューを開く', 'mitsumaru' ); ?></span>
		</button>
	</div>
</header>

<div class="offcanvas-backdrop" id="js-offcanvas-backdrop"></div>
<div class="offcanvas" id="js-offcanvas" aria-hidden="true">
	<button type="button" class="offcanvas__close" id="js-offcanvas-close">
		&times;
		<span class="screen-reader-text"><?php esc_html_e( 'メニューを閉じる', 'mitsumaru' ); ?></span>
	</button>
	<nav>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'offcanvas',
			'container'      => false,
			'fallback_cb'    => 'mitsu_primary_nav_fallback',
		) );
		?>
	</nav>
</div>

<main id="site-content">
