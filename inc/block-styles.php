<?php
/**
 * Core Block Styles
 *
 * Registers custom style variations for core (and third-party) blocks.
 *
 * @package Han_Group
 */

if ( ! function_exists( 'hang_block_styles' ) ) :
	/**
	 * Registers all custom block style variations for the theme.
	 */
	function hang_block_styles() {
		register_block_style(
			'core/group',
			array(
				'name'  => 'wrap-mobile',
				'label' => __( 'Wrap Mobile', 'han-group' ),
			)
		);


		register_block_style(
			'core/button',
			array(
				'name'  => 'alternative',
				'label' => __( 'Alternative', 'han-group' ),
			)
		);

		register_block_style(
			'core/button',
			array(
				'name'  => 'link',
				'label' => __( 'Link', 'han-group' ),
			)
		);

		register_block_style(
			'core/image',
			array(
				'name'  => 'scaled',
				'label' => __( 'Scaled', 'han-group' ),
			)
		);
	}
endif;
add_action( 'init', 'hang_block_styles' );
