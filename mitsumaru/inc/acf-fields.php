<?php
/**
 * ACF (Advanced Custom Fields, 無料版) フィールド定義。
 *
 * 管理画面のACF UIで作成せず、すべてPHPコードで定義しています。
 * → フィールド構成がテーマ本体と一緒にバージョン管理・環境間コピーされるため、
 *   「本番にはあるフィールドがステージングに無い」といった事故を防げます。
 * ACF無料版には Repeater / Flexible Content が無いため、可変個の行が必要な
 * 箇所（料金プランの内訳・制作メニュー表の行）は専用のカスタム投稿タイプ
 * (mitsu_menu_row) や、パイプ区切りのテキストエリアで代替しています。
 *
 * @package mitsumaru
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Notice if ACF is not active — most of the theme's editable content
 * relies on it.
 */
function mitsu_acf_admin_notice() {
	if ( ! function_exists( 'acf_add_local_field_group' ) && current_user_can( 'activate_plugins' ) ) {
		echo '<div class="notice notice-warning"><p>' .
			esc_html__( 'mitsumaru design テーマの各種入力項目には「Advanced Custom Fields」プラグイン（無料版）が必要です。プラグイン > 新規追加 からインストール・有効化してください。', 'mitsumaru' ) .
			'</p></div>';
	}
}
add_action( 'admin_notices', 'mitsu_acf_admin_notice' );

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', function () {

	/**
	 * Service Plan card (mitsu_service_plan)
	 */
	acf_add_local_field_group( array(
		'key'      => 'group_service_plan',
		'title'    => 'プラン内容',
		'fields'   => array(
			array(
				'key'   => 'field_plan_price_lead',
				'label' => '価格見出し（例：50万円〜）',
				'name'  => 'plan_price_lead',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_plan_description',
				'label' => '説明文',
				'name'  => 'plan_description',
				'type'  => 'textarea',
				'rows'  => 4,
			),
			array(
				'key'          => 'field_plan_price_breakdown',
				'label'        => '内訳（Priceボックス）',
				'name'         => 'plan_price_breakdown',
				'type'         => 'textarea',
				'rows'         => 5,
				'instructions' => '1行につき「項目名 | 金額」の形式で入力してください。例：デザイン&コーディング | 20万円',
			),
			array(
				'key'   => 'field_plan_total_price',
				'label' => '合計金額（例：50万）',
				'name'  => 'plan_total_price',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_plan_note',
				'label' => '注釈（例：※コーポレートサイト5ページ分の目安です）',
				'name'  => 'plan_note',
				'type'  => 'text',
			),
			array(
				'key'          => 'field_plan_features',
				'label'        => '内容（含まれるもの）',
				'name'         => 'plan_features',
				'type'         => 'textarea',
				'rows'         => 6,
				'instructions' => '1行につき1項目を入力してください。例：初回ヒアリング',
			),
			array(
				'key'          => 'field_plan_recommended',
				'label'        => 'おすすめの方・対象',
				'name'         => 'plan_recommended',
				'type'         => 'textarea',
				'rows'         => 5,
				'instructions' => '1行につき1項目を入力してください。「おすすめの方」「対象業種」のどちらにも使えます。',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mitsu_service_plan',
				),
			),
		),
	) );

	/**
	 * Menu table row (mitsu_menu_row)
	 */
	acf_add_local_field_group( array(
		'key'      => 'group_menu_row',
		'title'    => 'メニュー行の内容',
		'fields'   => array(
			array(
				'key'   => 'field_menu_row_price',
				'label' => '料金',
				'name'  => 'menu_row_price',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_menu_row_extra',
				'label' => '追加料金',
				'name'  => 'menu_row_extra',
				'type'  => 'text',
			),
			array(
				'key'          => 'field_menu_row_group',
				'label'        => '表グループ（同じカテゴリ内で表を分けたい場合のみ）',
				'name'         => 'menu_row_group',
				'type'         => 'text',
				'instructions' => '同じカテゴリ内に複数の表（例：素材支給型動画編集／モーション・プロモーション動画）を作りたい場合、同じ表に含めたい行すべてに同じグループ名を入力してください。空欄なら1つの表にまとまります。「グループ名 | 料金列見出し | 追加料金列見出し」の形式で入力すると、その表だけ見出しを変更できます（例：月額ショート動画プラン | 月額料金 | 内容）。',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mitsu_menu_row',
				),
			),
		),
	) );

	/**
	 * Work item (mitsu_work)
	 */
	acf_add_local_field_group( array(
		'key'      => 'group_work',
		'title'    => '実績の内容',
		'fields'   => array(
			array(
				'key'   => 'field_work_period',
				'label' => '制作期間（例：1ヵ月）',
				'name'  => 'work_period',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_work_price',
				'label' => '料金（例：10万円）',
				'name'  => 'work_price',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_work_url',
				'label' => '公開URL（任意）',
				'name'  => 'work_url',
				'type'  => 'url',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mitsu_work',
				),
			),
		),
	) );

	/**
	 * Recruitment item (mitsu_recruit)
	 * — モックアップに具体的なデザインが無かったため、Worksと対称的な
	 *   最小構成にしています。求人詳細に応じてフィールドを追加してください。
	 */
	acf_add_local_field_group( array(
		'key'      => 'group_recruit',
		'title'    => '募集要項',
		'fields'   => array(
			array(
				'key'   => 'field_recruit_employment_type',
				'label' => '雇用形態',
				'name'  => 'recruit_employment_type',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_recruit_salary',
				'label' => '給与',
				'name'  => 'recruit_salary',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_recruit_summary',
				'label' => '概要',
				'name'  => 'recruit_summary',
				'type'  => 'textarea',
				'rows'  => 3,
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mitsu_recruit',
				),
			),
		),
	) );

	/**
	 * service_category term fields — 各カテゴリ（Web / Motion / Paper media）
	 * ごとの制作メニュー表の見出し・配色・リード文。
	 */
	acf_add_local_field_group( array(
		'key'      => 'group_service_category_term',
		'title'    => 'サービスカテゴリの表示設定',
		'fields'   => array(
			array(
				'key'   => 'field_service_intro_text',
				'label' => 'リード文（ページ上部の説明文）',
				'name'  => 'service_intro_text',
				'type'  => 'textarea',
				'rows'  => 3,
			),
			array(
				'key'   => 'field_menu_table_heading',
				'label' => '制作メニュー表の見出し（例：Web制作メニュー）',
				'name'  => 'menu_table_heading',
				'type'  => 'text',
			),
			array(
				'key'          => 'field_menu_table_dark',
				'label'        => '制作メニュー表をダーク配色にする',
				'name'         => 'menu_table_dark',
				'type'         => 'true_false',
				'instructions' => '動画プランのような濃色テーブルにしたい場合はON。',
				'ui'           => 1,
			),
			array(
				'key'          => 'field_menu_table_price_label',
				'label'        => '料金列の見出し（初期値：料金）',
				'name'         => 'menu_table_price_label',
				'type'         => 'text',
				'instructions' => '「月額料金」など、テーブルの内容に合わせて変更できます。',
			),
			array(
				'key'          => 'field_menu_table_extra_label',
				'label'        => '追加料金列の見出し（初期値：追加料金）',
				'name'         => 'menu_table_extra_label',
				'type'         => 'text',
				'instructions' => '「内容」など、テーブルの内容に合わせて変更できます。行に何も入力しなければ列自体が非表示になります。',
			),
			array(
				'key'          => 'field_service_menu_items',
				'label'        => 'サービス一覧（カテゴリ上部のタグ表示）',
				'name'         => 'service_menu_items',
				'type'         => 'textarea',
				'rows'         => 6,
				'instructions' => '1行につき1項目を入力してください。例：コーポレートサイト',
			),
			array(
				'key'          => 'field_category_included_list',
				'label'        => '基本料金に含まれるもの',
				'name'         => 'category_included_list',
				'type'         => 'textarea',
				'rows'         => 6,
				'instructions' => '1行につき1項目を入力してください。',
			),
			array(
				'key'          => 'field_category_excluded_list',
				'label'        => '別途費用となるもの',
				'name'         => 'category_excluded_list',
				'type'         => 'textarea',
				'rows'         => 6,
				'instructions' => '1行につき1項目を入力してください。',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'service_category',
				),
			),
		),
	) );

} );
