<?php
/**
 * Custom Taxonomies
 *
 * Registers the taxonomies owned by this theme.
 *
 * @package Han_Group
 */

if ( ! function_exists( 'hang_register_event_type_taxonomy' ) ) :
	/**
	 * Registers the Type taxonomy for the Event post type.
	 *
	 * Hierarchical, so it presents the checkbox UI that categories use rather
	 * than the free-form tag input.
	 */
	function hang_register_event_type_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Types', 'taxonomy general name', 'han-group' ),
			'singular_name'              => _x( 'Type', 'taxonomy singular name', 'han-group' ),
			'menu_name'                  => __( 'Types', 'han-group' ),
			'all_items'                  => __( 'All Types', 'han-group' ),
			'edit_item'                  => __( 'Edit Type', 'han-group' ),
			'view_item'                  => __( 'View Type', 'han-group' ),
			'update_item'                => __( 'Update Type', 'han-group' ),
			'add_new_item'               => __( 'Add New Type', 'han-group' ),
			'new_item_name'              => __( 'New Type Name', 'han-group' ),
			'parent_item'                => __( 'Parent Type', 'han-group' ),
			'parent_item_colon'          => __( 'Parent Type:', 'han-group' ),
			'search_items'               => __( 'Search Types', 'han-group' ),
			'popular_items'              => __( 'Popular Types', 'han-group' ),
			'separate_items_with_commas' => __( 'Separate types with commas', 'han-group' ),
			'add_or_remove_items'        => __( 'Add or remove types', 'han-group' ),
			'choose_from_most_used'      => __( 'Choose from the most used types', 'han-group' ),
			'not_found'                  => __( 'No types found.', 'han-group' ),
			'no_terms'                   => __( 'No types', 'han-group' ),
			'back_to_items'              => __( '&larr; Go to Types', 'han-group' ),
			'item_link'                  => _x( 'Type Link', 'navigation link block title', 'han-group' ),
			'item_link_description'      => _x( 'A link to a type.', 'navigation link block description', 'han-group' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Groups events by type.', 'han-group' ),
			'public'             => true,
			'publicly_queryable' => true,
			'hierarchical'       => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_in_rest'       => true,
			'show_admin_column'  => true,
			'show_tagcloud'      => false,
			'query_var'          => true,
			'rewrite'            => array(
				'slug'         => 'event-type',
				'with_front'   => false,
				'hierarchical' => true,
			),
		);

		register_taxonomy( 'event-type', array( 'event' ), $args );
	}
endif;
add_action( 'init', 'hang_register_event_type_taxonomy' );
