<?php
/**
 * Han Group — Shortcodes Reference Page
 *
 * Adds an admin page under Appearance that showcases the shortcodes
 * bundled with this theme, each with a one-click copy button.
 *
 * @package Han_Group
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── Register the shortcode catalogue ──────────────────────────────────────────

if ( ! function_exists( 'hang_get_shortcodes' ) ) :
	/**
	 * Returns the list of theme shortcodes to display on the reference page.
	 *
	 * Each entry: label, the copy-ready shortcode, a description, and an
	 * optional list of attributes (name => description).
	 */
	function hang_get_shortcodes() {
		return array(
			array(
				'title'       => __( 'Posts Grid', 'han-group' ),
				'tag'         => 'hang_posts_grid',
				'description' => __( 'Renders a filterable, AJAX-paginated post grid with category filter tabs.', 'han-group' ),
				'example'     => '[hang_posts_grid per_page="9" post_type="post" categories="4,9"]',
				'attrs'       => array(
					array( 'name' => 'per_page',  'default' => '6',     'desc' => __( 'Number of posts to show per page.', 'han-group' ) ),
					array( 'name' => 'post_type', 'default' => 'post',  'desc' => __( 'WordPress post type slug.', 'han-group' ) ),
					array( 'name' => 'categories','default' => '(all)', 'desc' => __( 'Comma-separated category IDs. Leave empty to include all.', 'han-group' ) ),
					array( 'name' => 'id',        'default' => '(none)','desc' => __( 'Grid ID for remote tab connection via <code>[hang_posts_tabs]</code>.', 'han-group' ) ),
				),
			),
			array(
				'title'       => __( 'Posts Tabs (Remote)', 'han-group' ),
				'tag'         => 'hang_posts_tabs',
				'description' => __( 'Outputs standalone filter tabs that control a <code>[hang_posts_grid id="…"]</code> placed anywhere else on the same page.', 'han-group' ),
				'example'     => '[hang_posts_tabs for="blog" categories="4,9" post_type="post"]',
				'attrs'       => array(
					array( 'name' => 'for',       'default' => '(required)', 'desc' => __( 'Must match the <code>id</code> attribute of the target grid.', 'han-group' ) ),
					array( 'name' => 'categories','default' => '(all)',      'desc' => __( 'Comma-separated category IDs shown as filter tabs.', 'han-group' ) ),
					array( 'name' => 'post_type', 'default' => 'post',       'desc' => __( 'Post type slug — must match the target grid.', 'han-group' ) ),
				),
			),
		);
	}
endif;

// ── Add page under Appearance ─────────────────────────────────────────────────

add_action( 'admin_menu', 'hang_shortcodes_add_menu' );

if ( ! function_exists( 'hang_shortcodes_add_menu' ) ) :
	function hang_shortcodes_add_menu() {
		add_theme_page(
			__( 'Han Group Shortcodes', 'han-group' ),
			__( 'Han Group', 'han-group' ),
			'edit_theme_options',
			'hang-shortcodes',
			'hang_shortcodes_render_page'
		);
	}
endif;

// ── Enqueue admin assets on the Shortcodes page ────────────────────────────────

add_action( 'admin_enqueue_scripts', 'hang_shortcodes_admin_assets' );

if ( ! function_exists( 'hang_shortcodes_admin_assets' ) ) :
	function hang_shortcodes_admin_assets( $hook ) {
		if ( 'appearance_page_hang-shortcodes' !== $hook ) {
			return;
		}

		wp_enqueue_script(
			'hang-shortcodes-copy',
			get_theme_file_uri( 'assets/js/shortcodes-copy.js' ),
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
endif;

// ── Render the page ───────────────────────────────────────────────────────────

if ( ! function_exists( 'hang_shortcodes_render_page' ) ) :
	function hang_shortcodes_render_page() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$shortcodes = hang_get_shortcodes();
		?>
		<div class="wrap psr-wrap">

			<style>
				.psr-wrap { max-width: 960px; }
				.psr-header {
					display: flex;
					align-items: center;
					gap: 14px;
					margin: 24px 0 32px;
				}
				.psr-header__logo {
					width: 30px;
					height: 30px;
					display: flex;
					align-items: center;
					justify-content: center;
					flex-shrink: 0;
				}
				.psr-header__logo svg { display: block; }
				.psr-header__text h1 {
					margin: 0;
					font-size: 22px;
					font-weight: 600;
					line-height: 1.2;
					color: #1d2327;
				}
				.psr-header__text p {
					margin: 4px 0 0;
					color: #646970;
					font-size: 13px;
				}

				.psr-grid {
					display: flex;
					flex-direction: column;
					gap: 24px;
				}

				.psr-card {
					background: #fff;
					border: 1px solid #e2e4e7;
					border-radius: 12px;
					overflow: hidden;
				}
				.psr-card__head {
					padding: 20px 24px 16px;
					border-bottom: 1px solid #f0f0f0;
				}
				.psr-card__title-row {
					display: flex;
					align-items: center;
					gap: 10px;
					margin-bottom: 6px;
				}
				.psr-card__title {
					font-size: 16px;
					font-weight: 600;
					color: #1d2327;
					margin: 0;
				}
				.psr-card__badge {
					font-size: 11px;
					font-weight: 500;
					background: #f0f0f1;
					color: #646970;
					padding: 2px 8px;
					border-radius: 20px;
					font-family: monospace;
					letter-spacing: 0;
				}
				.psr-card__desc {
					margin: 0;
					color: #646970;
					font-size: 13px;
					line-height: 1.6;
				}
				.psr-card__desc code {
					background: #f6f7f7;
					padding: 1px 5px;
					border-radius: 3px;
					font-size: 12px;
					color: #2c3338;
				}

				.psr-card__body { padding: 20px 24px; }

				.psr-example-label {
					font-size: 11px;
					font-weight: 600;
					text-transform: uppercase;
					letter-spacing: .06em;
					color: #646970;
					margin: 0 0 8px;
				}
				.psr-example-row {
					display: flex;
					align-items: stretch;
					gap: 0;
					border: 1px solid #e2e4e7;
					border-radius: 8px;
					overflow: hidden;
					margin-bottom: 24px;
				}
				.psr-example-code {
					flex: 1;
					background: #f6f7f7;
					padding: 12px 16px;
					margin: 0;
					font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
					font-size: 13px;
					color: #2c3338;
					white-space: pre-wrap;
					word-break: break-all;
					border: none;
					line-height: 1.6;
				}
				.psr-copy-btn {
					flex-shrink: 0;
					padding: 0 16px;
					background: #fff;
					border: none;
					border-left: 1px solid #e2e4e7;
					cursor: pointer;
					font-size: 12px;
					font-weight: 500;
					color: #2271b1;
					display: flex;
					align-items: center;
					gap: 6px;
					transition: background .15s, color .15s;
					white-space: nowrap;
				}
				.psr-copy-btn:hover { background: #f0f6fc; }
				.psr-copy-btn.copied { color: #00a32a; }
				.psr-copy-btn svg { flex-shrink: 0; }

				.psr-attrs-label {
					font-size: 11px;
					font-weight: 600;
					text-transform: uppercase;
					letter-spacing: .06em;
					color: #646970;
					margin: 0 0 10px;
				}
				.psr-attrs {
					border: 1px solid #e2e4e7;
					border-radius: 8px;
					overflow: hidden;
				}
				.psr-attr {
					display: grid;
					grid-template-columns: 160px 100px 1fr;
					gap: 0;
					border-bottom: 1px solid #f0f0f0;
				}
				.psr-attr:last-child { border-bottom: none; }
				.psr-attr__name,
				.psr-attr__default,
				.psr-attr__desc {
					padding: 10px 14px;
					font-size: 13px;
					line-height: 1.5;
				}
				.psr-attr__name {
					font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
					font-size: 12px;
					color: #9333ea;
					background: #faf5ff;
					font-weight: 500;
					border-right: 1px solid #f0f0f0;
				}
				.psr-attr__default {
					font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
					font-size: 12px;
					color: #646970;
					background: #fafafa;
					border-right: 1px solid #f0f0f0;
				}
				.psr-attr__desc { color: #3c434a; }
				.psr-attr__desc code {
					background: #f6f7f7;
					padding: 1px 5px;
					border-radius: 3px;
					font-size: 12px;
					color: #2c3338;
				}

				.psr-attr-head {
					display: grid;
					grid-template-columns: 160px 100px 1fr;
					background: #f6f7f7;
					border-bottom: 1px solid #e2e4e7;
				}
				.psr-attr-head span {
					padding: 7px 14px;
					font-size: 11px;
					font-weight: 600;
					text-transform: uppercase;
					letter-spacing: .06em;
					color: #646970;
				}
				.psr-attr-head span:not(:last-child) {
					border-right: 1px solid #e2e4e7;
				}

				.psr-footer {
					margin-top: 32px;
					padding: 16px 20px;
					background: #f6f7f7;
					border: 1px solid #e2e4e7;
					border-radius: 10px;
					font-size: 13px;
					color: #646970;
					line-height: 1.6;
				}
				.psr-footer strong { color: #1d2327; }
			</style>

			<div class="psr-header">
				<div class="psr-header__logo">
					<svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="#8fa4b7"/>
					</svg>
				</div>
				<div class="psr-header__text">
					<h1><?php esc_html_e( 'Han Group Shortcodes', 'han-group' ); ?></h1>
					<p><?php esc_html_e( 'All shortcodes available in this theme. Click Copy to grab the code.', 'han-group' ); ?></p>
				</div>
			</div>

			<div class="psr-grid">
				<?php foreach ( $shortcodes as $sc ) : ?>
				<div class="psr-card">
					<div class="psr-card__head">
						<div class="psr-card__title-row">
							<h2 class="psr-card__title"><?php echo esc_html( $sc['title'] ); ?></h2>
							<span class="psr-card__badge"><?php echo esc_html( '[' . $sc['tag'] . ']' ); ?></span>
						</div>
						<p class="psr-card__desc"><?php echo wp_kses( $sc['description'], array( 'code' => array() ) ); ?></p>
					</div>

					<div class="psr-card__body">
						<p class="psr-example-label"><?php esc_html_e( 'Example', 'han-group' ); ?></p>
						<div class="psr-example-row">
							<pre class="psr-example-code"><?php echo esc_html( $sc['example'] ); ?></pre>
							<button
								type="button"
								class="psr-copy-btn"
								data-code="<?php echo esc_attr( $sc['example'] ); ?>"
							>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
									<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
								</svg>
								<?php esc_html_e( 'Copy', 'han-group' ); ?>
							</button>
						</div>

						<?php if ( ! empty( $sc['attrs'] ) ) : ?>
						<p class="psr-attrs-label"><?php esc_html_e( 'Attributes', 'han-group' ); ?></p>
						<div class="psr-attrs">
							<div class="psr-attr-head">
								<span><?php esc_html_e( 'Attribute', 'han-group' ); ?></span>
								<span><?php esc_html_e( 'Default', 'han-group' ); ?></span>
								<span><?php esc_html_e( 'Description', 'han-group' ); ?></span>
							</div>
							<?php foreach ( $sc['attrs'] as $attr ) : ?>
							<div class="psr-attr">
								<div class="psr-attr__name"><?php echo esc_html( $attr['name'] ); ?></div>
								<div class="psr-attr__default"><?php echo esc_html( $attr['default'] ); ?></div>
								<div class="psr-attr__desc"><?php echo wp_kses( $attr['desc'], array( 'code' => array() ) ); ?></div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="psr-footer">
				<strong><?php esc_html_e( 'Tip:', 'han-group' ); ?></strong>
				<?php esc_html_e( 'Shortcodes can be placed in any post, page, or widget that supports shortcodes. In the block editor, use the Shortcode block.', 'han-group' ); ?>
			</div>

		</div>
		<?php
	}
endif;
