# mitsumaru design オリジナルWPテーマ

支給されたUIモック（トップ / News / Service / Works）をもとに構築したオリジナルWordPressテーマです。
クラシックPHPテーマ（フルサイト編集は未使用）+ カスタム投稿タイプ + ACF（無料版）構成。

## 1. 必要環境・セットアップ

1. WordPress 6.0以上 / PHP 7.4以上のローカル環境を用意（Local by Flywheel / XAMPP / Docker等）。
2. `mitsumaru` フォルダを `wp-content/themes/` にコピーし、管理画面 > 外観 > テーマ から有効化。
3. プラグイン「**Advanced Custom Fields**」（無料版）をインストール・有効化。
   - 各投稿タイプの入力項目（料金・期間など）はすべてこのプラグインが提供します。未インストールだと管理画面に警告が出ます。
4. （任意・推奨）プラグイン「**Intuitive Custom Post Order**」を追加すると、プラン/メニュー行/実績/求人の並び替えがドラッグ&ドロップでできるようになります（無しでも「ページ属性 > 並び順」の数字入力で並び替え可能）。
5. 外観 > メニュー で `primary`（ヘッダー）・`offcanvas`（ハンバーガーパネル）にメニューを割り当て。未設定でも仮のリンク一式が自動表示されます。
6. 固定ページを作成：
   - スラッグ `about` の固定ページを作成すると、フッターの「About」リンクが自動でそこを指すようになります。
   - 「Contact」ページを作成し、テンプレートに **「Contact（お問い合わせ）」** を選択すると問い合わせフォームが表示されます。
7. 外観 > カスタマイズ から、SNSリンク・フッターコピーライト・問い合わせ送信先メール・トップの見出し文字を設定できます。

## 2. コンテンツ構造（カスタム投稿タイプ）

| 投稿タイプ | 用途 | URL | 主なフィールド |
|---|---|---|---|
| `mitsu_news` | News記事 | `/news/`, `/news/{slug}/` | 本文・アイキャッチ |
| `mitsu_work` | Works実績 | `/works/`, `/works-category/{web,motion,paper-media}/` | 制作期間・料金・公開URL・サムネイル |
| `mitsu_recruit` | 採用情報 | `/recruit/`, `/recruit-category/{...}/` | 雇用形態・給与・概要 ※デザイン未支給のため仮実装 |
| `mitsu_service_plan` | Serviceページの料金プランカード | 単独URLなし（管理画面のみ） | 価格見出し・説明・内訳・合計・注釈・内容（箇条書き）・おすすめの方/対象（箇条書き） |
| `mitsu_menu_row` | Serviceページの「制作メニュー表」の1行 | 単独URLなし（管理画面のみ） | 料金・追加料金・表グループ |

Service / Works / Recruitment はそれぞれ専用タクソノミー（`service_category` / `work_category` / `recruit_category`）を持ち、
初期値として「Web / Motion / Paper media」（Recruitmentのみ「Animation」も）が自動生成されます。
Serviceのみ、これに加えて「Landing page / SNS・広告 / 保守・運用 / セットプラン」の4カテゴリも自動生成されます。
**フッターのカテゴリ一覧・Serviceページの見出しは全てこのタクソノミーの用語（term）から自動生成される**ため、
新しいカテゴリを増やしたい場合はタクソノミー編集画面で用語を追加するだけで、フッターにも自動的にリンクが増えます。

### Serviceページの表示イメージ
`/service/web/` のようなタクソノミーアーカイブURL（`taxonomy-service_category.php`）が1ページとして機能し、

1. その用語（例：Web）にタグ付けされた `mitsu_service_plan` を「並び順」順に並べてプランカード表示
2. その用語にタグ付けされた `mitsu_menu_row` を並べて「制作メニュー表」を表示（見出し文言・ダーク配色切り替えは用語の編集画面から設定）

という構成です。1つの `mitsu_menu_row` に複数の用語（例：Web と Paper media 両方）を割り当てれば、
モックアップにあった「チラシページとWebページで同じ制作メニュー表を使い回す」動きを再現できます。

### 料金表の原稿を入力する場所

管理画面左メニューの「Service：料金プラン」「Service：制作メニュー表」から入力します
（どちらのサブメニューからも「サービスカテゴリ」の編集画面に入れます）。

| 入力したい内容 | 入力先 | 備考 |
|---|---|---|
| カテゴリ上部の「サービス一覧」タグ | サービスカテゴリ編集画面 > サービス一覧 | 1行1項目 |
| プラン（ライト/スタンダード/…、セットプラン、保守プランなど） | `mitsu_service_plan` を作成しカテゴリを割当 | タイトル＝プラン名／価格見出し／説明文／内容（1行1項目）／おすすめの方・対象（1行1項目）／内訳（`項目名 \| 金額`）／合計金額／注釈 |
| 一覧表の行（単体料金表・DTP料金表・動画料金表など） | `mitsu_menu_row` を作成しカテゴリを割当 | タイトル＝項目名／料金／追加料金（無ければ空欄でOK＝列ごと非表示） |
| 「基本料金に含まれるもの」「別途費用となるもの」 | サービスカテゴリ編集画面 | 1行1項目、DTPカテゴリなどカテゴリ全体にかかる注記に使用 |
| 1カテゴリ内に複数の表を分けたい場合（例：動画カテゴリの「素材支給型動画編集」「モーション・プロモーション動画」「月額ショート動画プラン」） | 各 `mitsu_menu_row` の「表グループ」欄 | 同じ表にしたい行に同じ文字列を入力。`グループ名 \| 料金列見出し \| 追加料金列見出し` の形式で見出し・列名も変更可（例：`月額ショート動画プラン \| 月額料金 \| 内容`） |
| 表の見出し・料金/追加料金列の見出し・ダーク配色（カテゴリ全体の初期値） | サービスカテゴリ編集画面 | 表グループ側で個別指定した場合はそちらが優先 |

## 3. なぜこの構成にしたか（管理のしやすさの工夫）

- **ACF無料版にはRepeater/Flexible Contentが無い**ため、「可変個の行」が必要な箇所（プラン一覧・メニュー表の行）は
  あえて別のカスタム投稿タイプに分けました。一覧画面で行の追加・削除・非表示が直感的に行え、
  将来ACF PROを導入すればRepeaterへ移行するのも部分的な変更で済みます。
- プラン内の「内訳（Priceボックス）」のように**1プラン内に閉じた短い行**（2〜5行程度）は、
  投稿タイプを増やすほどではないため `項目名 | 金額` 形式のテキストエリア1つで代替しています。
  （`inc/template-tags.php` の `mitsu_get_price_rows()` でパース）
- ACFのフィールド定義はすべて `inc/acf-fields.php` に**PHPコードとして記述**しています。
  管理画面のACF UIで作らないことで、本番・ステージング・ローカルの環境間でフィールド構成のズレが起きず、
  Gitでフィールド変更の差分レビューもできます。フィールドを増やしたい場合はこのファイルを編集してください。
- コメント機能は全投稿タイプで無効化しています（`functions.php`）。スパム対策の運用コストを減らすためです。
- お問い合わせフォームは外部プラグインに依存せず `inc/contact-form.php` で完結させています
  （nonce検証・ハニーポット・`wp_mail()`）。将来 Contact Form 7 等に置き換える場合は
  `page-contact.php` のフォームHTMLとこのファイルを差し替えるだけです。

## 4. ファイル構成

```
mitsumaru/
├── style.css                    … テーマ定義 + 全スタイル（CSSカスタムプロパティで配色管理）
├── functions.php                … セットアップ・enqueue・inc読み込み
├── inc/
│   ├── custom-post-types.php    … CPT・タクソノミー登録、一覧画面カラム、アーカイブ件数
│   ├── acf-fields.php           … ACFフィールド定義（PHP）
│   ├── template-tags.php        … ページネーション・価格パース等の共通関数
│   ├── customizer.php           … SNS・フッター・問い合わせ先などのサイト全体設定
│   ├── contact-form.php         … 問い合わせフォームの送信処理
│   └── admin.php                … 管理画面の補助表示
├── template-parts/
│   ├── service/                 … プランカード・メニュー表
│   ├── works/ , recruit/        … カード部品
├── header.php / footer.php      … 共通ヘッダー・フッター（オフキャンバスメニュー含む）
├── front-page.php               … トップページ（Hero + Newsカルーセル）
├── archive-mitsu_news.php / single-mitsu_news.php
├── archive-mitsu_work.php / taxonomy-work_category.php / single-mitsu_work.php
├── archive-mitsu_recruit.php / taxonomy-recruit_category.php / single-mitsu_recruit.php
├── taxonomy-service_category.php
├── page.php / page-contact.php / 404.php / index.php
└── assets/js/main.js            … オフキャンバス開閉・Newsカルーセル（jQuery不使用）
```

## 5. 今回のモックアップに無かったため仮実装にした箇所

- **Recruitmentページ**：デザイン支給が無かったため、Worksと対称的な最小構成（画像・雇用形態・給与）にしています。
  実際のデザインが決まり次第、`template-parts/recruit/recruit-card.php` 等を差し替えてください。
- **Aboutページ**：フッターにリンクのみで詳細デザインが無かったため、通常の固定ページ（`page.php`）として扱っています。

## 6. デザイントークン（XDファイル解析による確定値）

初回実装時はスクリーンショット画像からの目視推定で配色・フォントを組んでいましたが、
`web/mitusumaru design.xd` を解析し直し、以下の実データに更新しています（`style.css` の `:root` 参照）。

| 用途 | 値 |
|---|---|
| 本文テキスト | `#333333` |
| Hero帯（グレー） | `#dcdcdc` |
| サムネイル/マスクのプレースホルダー | `#cecece` |
| フッター・About背景 | `#d2d6c4` |
| アクセント（ヘッダー罫線・Priceボックス・ボタン） | オリーブ `#858e78` |
| アクセント（丸の縁取り・アイコン） | ダークティール `#1e464e` |
| Priceボックス内の文字色 | クリーム `#fef6ed` |
| 動画プランの制作メニュー表（全面ダーク） | スレート `#8694a0` |
| 割引・強調表示（例：`-2万円→0円`） | オレンジ `#ff9777` |

**フォントは3種構成**です（`functions.php` の `mitsu_assets()` で読み込み）。
- 見出し・ロゴ・価格表示：`Century Gothic Pro`（Adobe Fonts / Typekit経由、キットID `sjv5unx`。外観 > カスタマイズ > フォント設定で変更可能）
- 本文（日本語）：`Noto Sans JP`（Google Fonts）
- ページ送りの数字のみ：`Zen Maru Gothic`（Google Fonts）

Adobe Fontsキットは同社のCreative Cloud契約（または無料Adobe ID）が有効な間のみ配信されるため、
契約が途切れるとキットのURLが404になり見出しフォントが崩れます。契約状況にご注意ください。

Priceボックス右側の縦書き「PRICE」の透かし文字は意図した装飾要素のため、`style.css` の
`.price-box::before` で実装しています。

## 7. 今後の運用でおすすめしたいこと

- 本番公開前に `assets/img/screenshot.png`（1200×900推奨）を用意すると管理画面のテーマ一覧に表示されます。
- 表示件数（News:10件、Works/Recruit:9件）は `inc/custom-post-types.php` の `mitsu_archive_query_vars()` で調整できます。
- 今回の色・フォントは1280px幅のXDデザインを基準にしています。実機でズレを感じた場合は、`style.css` の `:root` 内の値を再調整してください。
