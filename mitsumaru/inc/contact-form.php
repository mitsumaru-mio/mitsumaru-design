<?php
/**
 * Lightweight native contact-form handler (no external plugin dependency).
 * Posts to admin-post.php, verifies a nonce + honeypot, then wp_mail()s
 * the address configured in Customizer > お問い合わせ設定.
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mitsu_handle_contact_submit() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );

	if ( ! isset( $_POST['mitsu_contact_nonce'] ) || ! wp_verify_nonce( $_POST['mitsu_contact_nonce'], 'mitsu_contact_submit' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $redirect ) );
		exit;
	}

	// Honeypot: real users never fill this hidden field.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'success', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$tel     = isset( $_POST['contact_tel'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_tel'] ) ) : '';
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $redirect ) );
		exit;
	}

	$to      = mitsu_get_option( 'mitsu_contact_email', get_option( 'admin_email' ) );
	$subject = sprintf( '[%s] お問い合わせ', get_bloginfo( 'name' ) );
	$body    = "お名前: {$name}\nメール: {$email}\n電話番号: {$tel}\n\nお問い合わせ内容:\n{$message}\n";
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'success' : 'error', $redirect ) );
	exit;
}
add_action( 'admin_post_mitsu_contact_submit', 'mitsu_handle_contact_submit' );
add_action( 'admin_post_nopriv_mitsu_contact_submit', 'mitsu_handle_contact_submit' );
