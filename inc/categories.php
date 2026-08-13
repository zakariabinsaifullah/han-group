<?php
/**
 * Block & Pattern Categories
 *
 * Registers custom block categories and block pattern categories
 * used throughout this theme.
 *
 * @package Han_Group
 */

if ( ! function_exists( 'hang_block_categories' ) ) :
	/**
	 * Adds the "Brilliant Blocks" category to the block inserter.
	 *
	 * @param  array                   $block_categories     Existing block categories.
	 * @param  WP_Block_Editor_Context $block_editor_context Current editor context.
	 * @return array
	 */
	function hang_block_categories( $block_categories, $block_editor_context ) {
		return array_merge(
			array(
				array(
					'slug'  => 'hang',
					'title' => __( 'Han Group', 'han-group' ),
				),
			),
			$block_categories

		);
	}
endif;
add_filter( 'block_categories_all', 'hang_block_categories', 10, 2 );


if ( ! function_exists( 'hang_pattern_categories' ) ) :
	/**
	 * Registers the "Han Group" block pattern category.
	 */
	function hang_pattern_categories() {
		register_block_pattern_category(
			'hang',
			array(
				'label'       => __( 'Han Group', 'han-group' ),
				'description' => __( 'A collection of Han Group patterns.', 'han-group' ),
			)
		);
	}
endif;
add_action( 'init', 'hang_pattern_categories' );


// ── ID column on the Categories admin screen ──────────────────────────────────

if ( ! function_exists( 'hang_category_columns' ) ) :
	/**
	 * Adds an "ID" column to the Categories list table.
	 *
	 * @param  array $columns Existing column definitions.
	 * @return array
	 */
	function hang_category_columns( $columns ) {
		$columns['hang_id'] = __( 'ID', 'han-group' );
		return $columns;
	}
endif;
add_filter( 'manage_edit-category_columns', 'hang_category_columns' );

/**
 * Caps the ID column width on the Categories list table.
 */
function hang_category_column_width() {
	?>
	<style>
		.wp-list-table .column-hang_id {
			width: 100px;
			max-width: 100px;
		}
	</style>
	<?php
}
add_action( 'admin_head-edit-tags.php', 'hang_category_column_width' );


if ( ! function_exists( 'hang_category_column_content' ) ) :
	/**
	 * Outputs the term ID for the custom column.
	 *
	 * @param  string $content      Column content.
	 * @param  string $column_name  Column key.
	 * @param  int    $term_id      Term ID.
	 * @return string
	 */
	function hang_category_column_content( $content, $column_name, $term_id ) {
		if ( 'hang_id' === $column_name ) {
			return (string) $term_id;
		}
		return $content;
	}
endif;
add_filter( 'manage_category_custom_column', 'hang_category_column_content', 10, 3 );
