<?php
/**
 * Google Analytics (gtag.js).
 *
 * 測定IDは 外観 > カスタマイズ > アクセス解析 で変更できます。
 * ログイン中の管理者自身のアクセスを計測から除外したい場合は、
 * GA4管理画面側の「内部トラフィック」フィルタ設定を利用してください。
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mitsu_output_ga_tag() {
	$measurement_id = mitsu_get_option( 'mitsu_ga_measurement_id', '' );

	if ( ! $measurement_id ) {
		return;
	}
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $measurement_id ); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo esc_js( $measurement_id ); ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'mitsu_output_ga_tag', 1 );
