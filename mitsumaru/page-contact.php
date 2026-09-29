<?php
/**
 * Template Name: Contact（お問い合わせ）
 *
 * 固定ページを作成し、テンプレートに「Contact」を選ぶと使用されます。
 * 送信は functions.php 経由の inc/contact-form.php が admin-post.php で処理します。
 *
 * @package mitsumaru
 */

get_header();

$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
?>

<section class="hero">
	<h1 class="hero__word">mitsumaru</h1>
</section>

<section class="page-content">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>

		<?php if ( 'success' === $status ) : ?>
			<p class="form-message form-message--success"><?php esc_html_e( 'お問い合わせありがとうございます。内容を送信しました。', 'mitsumaru' ); ?></p>
		<?php elseif ( 'error' === $status ) : ?>
			<p class="form-message form-message--error"><?php esc_html_e( '送信に失敗しました。入力内容をご確認のうえ、再度お試しください。', 'mitsumaru' ); ?></p>
		<?php endif; ?>

		<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="mitsu_contact_submit">
			<?php wp_nonce_field( 'mitsu_contact_submit', 'mitsu_contact_nonce' ); ?>
			<p class="honeypot-field">
				<label for="website"><?php esc_html_e( 'Webサイト', 'mitsumaru' ); ?></label>
				<input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
			</p>

			<div class="form-row">
				<label for="contact_name"><?php esc_html_e( 'お名前', 'mitsumaru' ); ?> <span aria-hidden="true">*</span></label>
				<input type="text" name="contact_name" id="contact_name" required>
			</div>

			<div class="form-row">
				<label for="contact_email"><?php esc_html_e( 'メールアドレス', 'mitsumaru' ); ?> <span aria-hidden="true">*</span></label>
				<input type="email" name="contact_email" id="contact_email" required>
			</div>

			<div class="form-row">
				<label for="contact_tel"><?php esc_html_e( '電話番号', 'mitsumaru' ); ?></label>
				<input type="tel" name="contact_tel" id="contact_tel">
			</div>

			<div class="form-row">
				<label for="contact_message"><?php esc_html_e( 'お問い合わせ内容', 'mitsumaru' ); ?> <span aria-hidden="true">*</span></label>
				<textarea name="contact_message" id="contact_message" required></textarea>
			</div>

			<button type="submit"><?php esc_html_e( '送信する', 'mitsumaru' ); ?></button>
		</form>
	</div>
</section>

<?php get_footer(); ?>
