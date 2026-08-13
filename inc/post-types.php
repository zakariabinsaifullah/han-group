<?php
/**
 * Custom Post Types
 *
 * Registers the content types owned by this theme.
 *
 * @package Han_Group
 */

if ( ! function_exists( 'hang_register_event_post_type' ) ) :
	/**
	 * Registers the Event post type.
	 *
	 * `show_in_rest` is required for the block editor to load; without it the
	 * `editor` support below falls back to the classic editor.
	 */
	function hang_register_event_post_type() {
		$labels = array(
			'name'                     => _x( 'Events', 'post type general name', 'han-group' ),
			'singular_name'            => _x( 'Event', 'post type singular name', 'han-group' ),
			'menu_name'                => _x( 'Events', 'admin menu', 'han-group' ),
			'name_admin_bar'           => _x( 'Event', 'add new on admin bar', 'han-group' ),
			'add_new'                  => __( 'Add Event', 'han-group' ),
			'add_new_item'             => __( 'Add New Event', 'han-group' ),
			'new_item'                 => __( 'New Event', 'han-group' ),
			'edit_item'                => __( 'Edit Event', 'han-group' ),
			'view_item'                => __( 'View Event', 'han-group' ),
			'view_items'               => __( 'View Events', 'han-group' ),
			'all_items'                => __( 'All Events', 'han-group' ),
			'search_items'             => __( 'Search Events', 'han-group' ),
			'parent_item_colon'        => __( 'Parent Events:', 'han-group' ),
			'not_found'                => __( 'No events found.', 'han-group' ),
			'not_found_in_trash'       => __( 'No events found in Trash.', 'han-group' ),
			'archives'                 => __( 'Event Archives', 'han-group' ),
			'attributes'               => __( 'Event Attributes', 'han-group' ),
			'insert_into_item'         => __( 'Insert into event', 'han-group' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this event', 'han-group' ),
			'featured_image'           => __( 'Event Image', 'han-group' ),
			'set_featured_image'       => __( 'Set event image', 'han-group' ),
			'remove_featured_image'    => __( 'Remove event image', 'han-group' ),
			'use_featured_image'       => __( 'Use as event image', 'han-group' ),
			'filter_items_list'        => __( 'Filter events list', 'han-group' ),
			'items_list_navigation'    => __( 'Events list navigation', 'han-group' ),
			'items_list'               => __( 'Events list', 'han-group' ),
			'item_published'           => __( 'Event published.', 'han-group' ),
			'item_updated'             => __( 'Event updated.', 'han-group' ),
			'item_scheduled'           => __( 'Event scheduled.', 'han-group' ),
			'item_reverted_to_draft'   => __( 'Event reverted to draft.', 'han-group' ),
			'item_link'                => _x( 'Event Link', 'navigation link block title', 'han-group' ),
			'item_link_description'    => _x( 'A link to an event.', 'navigation link block description', 'han-group' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Events organised by Han Group.', 'han-group' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_in_rest'       => true,
			'query_var'          => true,
			'rewrite'            => array(
				'slug'       => 'events',
				'with_front' => false,
			),
			'capability_type'    => 'post',
			'has_archive'        => 'events',
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-calendar-alt',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		);

		register_post_type( 'event', $args );
	}
endif;
add_action( 'init', 'hang_register_event_post_type' );


if ( ! function_exists( 'hang_event_title_placeholder' ) ) :
	/**
	 * Replaces the "Add title" placeholder on the Event editing screen.
	 *
	 * Core passes this filter through to the block editor as
	 * `titlePlaceholder`, so the one filter covers both editors.
	 *
	 * @param string  $text Current placeholder text.
	 * @param WP_Post $post Post being edited.
	 * @return string
	 */
	function hang_event_title_placeholder( $text, $post ) {
		if ( $post instanceof WP_Post && 'event' === $post->post_type ) {
			return __( 'Event title', 'han-group' );
		}

		return $text;
	}
endif;
add_filter( 'enter_title_here', 'hang_event_title_placeholder', 10, 2 );


if ( ! function_exists( 'hang_register_team_post_type' ) ) :
	/**
	 * Registers the Team post type.
	 *
	 * Team members have no front-end single view, so `publicly_queryable`
	 * and `query_var` stay off. `show_in_rest` keeps the block editor
	 * available in the admin.
	 */
	function hang_register_team_post_type() {
		$labels = array(
			'name'                  => _x( 'Team Members', 'post type general name', 'han-group' ),
			'singular_name'         => _x( 'Team Member', 'post type singular name', 'han-group' ),
			'menu_name'             => _x( 'Team', 'admin menu', 'han-group' ),
			'name_admin_bar'        => _x( 'Team Member', 'add new on admin bar', 'han-group' ),
			'add_new'               => __( 'Add Team Member', 'han-group' ),
			'add_new_item'          => __( 'Add New Member', 'han-group' ),
			'new_item'              => __( 'New Team Member', 'han-group' ),
			'edit_item'             => __( 'Edit Team Member', 'han-group' ),
			'view_item'             => __( 'View Team Member', 'han-group' ),
			'view_items'            => __( 'View Team Members', 'han-group' ),
			'all_items'             => __( 'All Team Members', 'han-group' ),
			'search_items'          => __( 'Search Team Members', 'han-group' ),
			'parent_item_colon'     => __( 'Parent Team Members:', 'han-group' ),
			'not_found'             => __( 'No team members found.', 'han-group' ),
			'not_found_in_trash'    => __( 'No team members found in Trash.', 'han-group' ),
			'archives'              => __( 'Team Member Archives', 'han-group' ),
			'attributes'            => __( 'Team Member Attributes', 'han-group' ),
			'insert_into_item'      => __( 'Insert into team member', 'han-group' ),
			'uploaded_to_this_item' => __( 'Uploaded to this team member', 'han-group' ),
			'featured_image'        => __( 'Team Member Photo', 'han-group' ),
			'set_featured_image'    => __( 'Set team member photo', 'han-group' ),
			'remove_featured_image' => __( 'Remove team member photo', 'han-group' ),
			'use_featured_image'    => __( 'Use as team member photo', 'han-group' ),
			'filter_items_list'     => __( 'Filter team members list', 'han-group' ),
			'items_list_navigation' => __( 'Team members list navigation', 'han-group' ),
			'items_list'            => __( 'Team members list', 'han-group' ),
			'item_published'        => __( 'Team member published.', 'han-group' ),
			'item_updated'          => __( 'Team member updated.', 'han-group' ),
			'item_scheduled'        => __( 'Team member scheduled.', 'han-group' ),
			'item_reverted_to_draft' => __( 'Team member reverted to draft.', 'han-group' ),
			'item_link'             => _x( 'Team Member Link', 'navigation link block title', 'han-group' ),
			'item_link_description' => _x( 'A link to a team member.', 'navigation link block description', 'han-group' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Team members of Han Group.', 'han-group' ),
			'public'             => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
			'show_in_rest'       => true,
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 21,
			'menu_icon'          => 'dashicons-groups',
			'supports'           => array( 'title', 'thumbnail' ),
		);

		register_post_type( 'team', $args );
	}
endif;
add_action( 'init', 'hang_register_team_post_type' );


if ( ! function_exists( 'hang_team_title_placeholder' ) ) :
	/**
	 * Replaces the "Add title" placeholder on the Team editing screen.
	 *
	 * Core passes this filter through to the block editor as
	 * `titlePlaceholder`, so the one filter covers both editors.
	 *
	 * @param string  $text Current placeholder text.
	 * @param WP_Post $post Post being edited.
	 * @return string
	 */
	function hang_team_title_placeholder( $text, $post ) {
		if ( $post instanceof WP_Post && 'team' === $post->post_type ) {
			return __( 'Enter name', 'han-group' );
		}

		return $text;
	}
endif;
add_filter( 'enter_title_here', 'hang_team_title_placeholder', 10, 2 );


if ( ! function_exists( 'hang_register_team_meta' ) ) :
	/**
	 * Registers the designation and short intro meta fields for the Team post type.
	 *
	 * `show_in_rest` exposes the fields through the REST API so they can be
	 * bound to blocks in the editor and queried from custom templates.
	 */
	function hang_register_team_meta() {
		register_post_meta(
			'team',
			'hang_designation',
			array(
				'type'              => 'string',
				'description'       => __( 'Job title or designation of the team member.', 'han-group' ),
				'single'            => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
				'show_in_rest'      => true,
			)
		);

		register_post_meta(
			'team',
			'hang_short_intro',
			array(
				'type'              => 'string',
				'description'       => __( 'Short introduction of the team member.', 'han-group' ),
				'single'            => true,
				'sanitize_callback' => 'sanitize_textarea_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
				'show_in_rest'      => true,
			)
		);
	}
endif;
add_action( 'init', 'hang_register_team_meta' );


if ( ! function_exists( 'hang_add_team_meta_box' ) ) :
	/**
	 * Adds the Team Details meta box to the Team editing screen.
	 */
	function hang_add_team_meta_box() {
		add_meta_box(
			'hang-team-details',
			__( 'Team Details', 'han-group' ),
			'hang_render_team_meta_box',
			'team',
			'normal',
			'default'
		);
	}
endif;
add_action( 'add_meta_boxes', 'hang_add_team_meta_box' );


if ( ! function_exists( 'hang_render_team_meta_box' ) ) :
	/**
	 * Renders the designation and short intro fields inside the meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	function hang_render_team_meta_box( $post ) {
		$designation = get_post_meta( $post->ID, 'hang_designation', true );
		$short_intro = get_post_meta( $post->ID, 'hang_short_intro', true );

		wp_nonce_field( 'hang_save_team_meta', 'hang_team_meta_nonce' );
		?>
		<p>
			<label for="hang-designation"><?php esc_html_e( 'Designation', 'han-group' ); ?></label>
			<input
				type="text"
				id="hang-designation"
				name="hang_designation"
				value="<?php echo esc_attr( $designation ); ?>"
				class="widefat"
			/>
		</p>
		<p>
			<label for="hang-short-intro"><?php esc_html_e( 'Short Intro', 'han-group' ); ?></label>
			<textarea
				id="hang-short-intro"
				name="hang_short_intro"
				class="widefat"
				rows="4"
			><?php echo esc_textarea( $short_intro ); ?></textarea>
		</p>
		<?php
	}
endif;


if ( ! function_exists( 'hang_save_team_meta' ) ) :
	/**
	 * Saves the designation and short intro meta fields when a Team member is saved.
	 *
	 * @param int $post_id Post ID.
	 */
	function hang_save_team_meta( $post_id ) {
		if (
			! isset( $_POST['hang_team_meta_nonce'] ) ||
			! wp_verify_nonce( sanitize_key( $_POST['hang_team_meta_nonce'] ), 'hang_save_team_meta' )
		) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['hang_designation'] ) ) {
			update_post_meta( $post_id, 'hang_designation', sanitize_text_field( wp_unslash( $_POST['hang_designation'] ) ) );
		}

		if ( isset( $_POST['hang_short_intro'] ) ) {
			update_post_meta( $post_id, 'hang_short_intro', sanitize_textarea_field( wp_unslash( $_POST['hang_short_intro'] ) ) );
		}
	}
endif;
add_action( 'save_post_team', 'hang_save_team_meta' );


// ── ID column on the Team admin screen ────────────────────────────────────────

if ( ! function_exists( 'hang_team_columns' ) ) :
	/**
	 * Adds an "ID" column to the Team Members list table.
	 *
	 * @param  array $columns Existing column definitions.
	 * @return array
	 */
	function hang_team_columns( $columns ) {
		$columns['hang_team_id'] = __( 'ID', 'han-group' );
		return $columns;
	}
endif;
add_filter( 'manage_team_posts_columns', 'hang_team_columns' );


if ( ! function_exists( 'hang_team_column_content' ) ) :
	/**
	 * Outputs the post ID for the custom column.
	 *
	 * @param  string $column_name Column key.
	 * @param  int    $post_id     Post ID.
	 * @return void
	 */
	function hang_team_column_content( $column_name, $post_id ) {
		if ( 'hang_team_id' === $column_name ) {
			echo esc_html( (string) $post_id );
		}
	}
endif;
add_action( 'manage_team_posts_custom_column', 'hang_team_column_content', 10, 2 );


/**
 * Caps the ID column width on the Team Members list table.
 */
function hang_team_column_width() {
	?>
	<style>
		.wp-list-table .column-hang_team_id {
			width: 70px;
			max-width: 70px;
		}
	</style>
	<?php
}
add_action( 'admin_head-edit.php', 'hang_team_column_width' );


if ( ! function_exists( 'hang_register_open_role_post_type' ) ) :
	/**
	 * Registers the Open Role post type for job listings.
	 *
	 * Roles have no front-end single view, so `publicly_queryable`, `query_var`
	 * and `rewrite` stay off and no archive is registered. `show_in_rest` keeps
	 * the block editor available in the admin.
	 */
	function hang_register_open_role_post_type() {
		$labels = array(
			'name'                   => _x( 'Open Roles', 'post type general name', 'han-group' ),
			'singular_name'          => _x( 'Open Role', 'post type singular name', 'han-group' ),
			'menu_name'              => _x( 'Open Roles', 'admin menu', 'han-group' ),
			'name_admin_bar'         => _x( 'Open Role', 'add new on admin bar', 'han-group' ),
			'add_new'                => __( 'Add Open Role', 'han-group' ),
			'add_new_item'           => __( 'Add New Open Role', 'han-group' ),
			'new_item'               => __( 'New Open Role', 'han-group' ),
			'edit_item'              => __( 'Edit Open Role', 'han-group' ),
			'view_item'              => __( 'View Open Role', 'han-group' ),
			'view_items'             => __( 'View Open Roles', 'han-group' ),
			'all_items'              => __( 'All Open Roles', 'han-group' ),
			'search_items'           => __( 'Search Open Roles', 'han-group' ),
			'parent_item_colon'      => __( 'Parent Open Roles:', 'han-group' ),
			'not_found'              => __( 'No open roles found.', 'han-group' ),
			'not_found_in_trash'     => __( 'No open roles found in Trash.', 'han-group' ),
			'archives'               => __( 'Open Role Archives', 'han-group' ),
			'attributes'             => __( 'Open Role Attributes', 'han-group' ),
			'insert_into_item'       => __( 'Insert into open role', 'han-group' ),
			'uploaded_to_this_item'  => __( 'Uploaded to this open role', 'han-group' ),
			'filter_items_list'      => __( 'Filter open roles list', 'han-group' ),
			'items_list_navigation'  => __( 'Open roles list navigation', 'han-group' ),
			'items_list'             => __( 'Open roles list', 'han-group' ),
			'item_published'         => __( 'Open role published.', 'han-group' ),
			'item_updated'           => __( 'Open role updated.', 'han-group' ),
			'item_scheduled'         => __( 'Open role scheduled.', 'han-group' ),
			'item_reverted_to_draft' => __( 'Open role reverted to draft.', 'han-group' ),
			'item_link'              => _x( 'Open Role Link', 'navigation link block title', 'han-group' ),
			'item_link_description'  => _x( 'A link to an open role.', 'navigation link block description', 'han-group' ),
		);

		$args = array(
			'labels'              => $labels,
			'description'         => __( 'Open roles at Han Group.', 'han-group' ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => true,
			'query_var'           => false,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => 22,
			'menu_icon'           => 'dashicons-businessperson',
			'supports'            => array( 'title' ),
		);

		register_post_type( 'open-role', $args );
	}
endif;
add_action( 'init', 'hang_register_open_role_post_type' );


if ( ! function_exists( 'hang_open_role_title_placeholder' ) ) :
	/**
	 * Replaces the "Add title" placeholder on the Open Role editing screen.
	 *
	 * Core passes this filter through to the block editor as
	 * `titlePlaceholder`, so the one filter covers both editors.
	 *
	 * @param string  $text Current placeholder text.
	 * @param WP_Post $post Post being edited.
	 * @return string
	 */
	function hang_open_role_title_placeholder( $text, $post ) {
		if ( $post instanceof WP_Post && 'open-role' === $post->post_type ) {
			return __( 'Role title', 'han-group' );
		}

		return $text;
	}
endif;
add_filter( 'enter_title_here', 'hang_open_role_title_placeholder', 10, 2 );


// ── Open Role meta fields ─────────────────────────────────────────────────────

if ( ! function_exists( 'hang_open_role_type_options' ) ) :
	/**
	 * Employment type choices, keyed by the value stored in meta.
	 *
	 * @return array
	 */
	function hang_open_role_type_options() {
		return array(
			'full-time'   => __( 'Full Time', 'han-group' ),
			'part-time'   => __( 'Part Time', 'han-group' ),
			'hourly'      => __( 'Hourly', 'han-group' ),
			'contractual' => __( 'Contractual', 'han-group' ),
			'internship'  => __( 'Internship', 'han-group' ),
		);
	}
endif;


if ( ! function_exists( 'hang_open_role_nature_options' ) ) :
	/**
	 * Work arrangement choices, keyed by the value stored in meta.
	 *
	 * @return array
	 */
	function hang_open_role_nature_options() {
		return array(
			'remote'   => __( 'Remote', 'han-group' ),
			'in-house' => __( 'In House', 'han-group' ),
			'hybrid'   => __( 'Hybrid', 'han-group' ),
		);
	}
endif;


if ( ! function_exists( 'hang_register_open_role_meta' ) ) :
	/**
	 * Registers the Open Role meta fields.
	 *
	 * `show_in_rest` exposes the fields through the REST API so they can be
	 * bound to blocks in the editor and queried from custom templates.
	 */
	function hang_register_open_role_meta() {
		$auth = function () {
			return current_user_can( 'edit_posts' );
		};

		$text_fields = array(
			'hang_role_location'     => __( 'Where the role is based.', 'han-group' ),
			'hang_role_salary_range' => __( 'Advertised salary range for the role.', 'han-group' ),
			'hang_role_match_rate'   => __( 'Candidate match percentage, shown on role cards as "92% match".', 'han-group' ),
		);

		foreach ( $text_fields as $key => $description ) {
			register_post_meta(
				'open-role',
				$key,
				array(
					'type'              => 'string',
					'description'       => $description,
					'single'            => true,
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => $auth,
					'show_in_rest'      => true,
				)
			);
		}

		register_post_meta(
			'open-role',
			'hang_role_type',
			array(
				'type'              => 'string',
				'description'       => __( 'Employment type of the role.', 'han-group' ),
				'single'            => true,
				'default'           => 'full-time',
				'sanitize_callback' => 'hang_sanitize_open_role_type',
				'auth_callback'     => $auth,
				'show_in_rest'      => true,
			)
		);

		register_post_meta(
			'open-role',
			'hang_role_nature',
			array(
				'type'              => 'string',
				'description'       => __( 'Work arrangement for the role.', 'han-group' ),
				'single'            => true,
				'default'           => 'remote',
				'sanitize_callback' => 'hang_sanitize_open_role_nature',
				'auth_callback'     => $auth,
				'show_in_rest'      => true,
			)
		);

		register_post_meta(
			'open-role',
			'hang_role_active',
			array(
				'type'          => 'boolean',
				'description'   => __( 'Whether the role is currently open.', 'han-group' ),
				'single'        => true,
				'default'       => true,
				'auth_callback' => $auth,
				'show_in_rest'  => true,
			)
		);

		register_post_meta(
			'open-role',
			'hang_role_apply_link',
			array(
				'type'              => 'string',
				'description'       => __( 'URL applicants are sent to.', 'han-group' ),
				'single'            => true,
				'default'           => '',
				'sanitize_callback' => 'sanitize_url',
				'auth_callback'     => $auth,
				'show_in_rest'      => true,
			)
		);
	}
endif;
add_action( 'init', 'hang_register_open_role_meta' );


if ( ! function_exists( 'hang_sanitize_open_role_type' ) ) :
	/**
	 * Falls back to the default when the value is not a known type.
	 *
	 * @param  string $value Submitted value.
	 * @return string
	 */
	function hang_sanitize_open_role_type( $value ) {
		return array_key_exists( $value, hang_open_role_type_options() ) ? $value : 'full-time';
	}
endif;


if ( ! function_exists( 'hang_sanitize_open_role_nature' ) ) :
	/**
	 * Falls back to the default when the value is not a known arrangement.
	 *
	 * @param  string $value Submitted value.
	 * @return string
	 */
	function hang_sanitize_open_role_nature( $value ) {
		return array_key_exists( $value, hang_open_role_nature_options() ) ? $value : 'remote';
	}
endif;


if ( ! function_exists( 'hang_add_open_role_meta_box' ) ) :
	/**
	 * Adds the Role Details meta box to the Open Role editing screen.
	 */
	function hang_add_open_role_meta_box() {
		add_meta_box(
			'hang-open-role-details',
			__( 'Role Details', 'han-group' ),
			'hang_render_open_role_meta_box',
			'open-role',
			'normal',
			'default'
		);
	}
endif;
add_action( 'add_meta_boxes', 'hang_add_open_role_meta_box' );


if ( ! function_exists( 'hang_render_open_role_meta_box' ) ) :
	/**
	 * Renders the Open Role fields inside the meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	function hang_render_open_role_meta_box( $post ) {
		$location   = get_post_meta( $post->ID, 'hang_role_location', true );
		$salary     = get_post_meta( $post->ID, 'hang_role_salary_range', true );
		$type       = get_post_meta( $post->ID, 'hang_role_type', true );
		$nature     = get_post_meta( $post->ID, 'hang_role_nature', true );
		$match_rate = get_post_meta( $post->ID, 'hang_role_match_rate', true );
		$apply_link = get_post_meta( $post->ID, 'hang_role_apply_link', true );

		// A post saved before these fields existed has no stored value, and
		// register_post_meta defaults do not apply to an unsaved draft either.
		$type   = $type ? $type : 'full-time';
		$nature = $nature ? $nature : 'remote';

		/*
		 * The toggle defaults to on. `metadata_exists` distinguishes "never
		 * saved" (default to active) from "saved as off" (an empty string,
		 * which would otherwise look identical to a missing value).
		 */
		$active = metadata_exists( 'post', $post->ID, 'hang_role_active' )
			? (bool) get_post_meta( $post->ID, 'hang_role_active', true )
			: true;

		wp_nonce_field( 'hang_save_open_role_meta', 'hang_open_role_meta_nonce' );
		?>
		<p>
			<label for="hang-role-active">
				<input
					type="checkbox"
					id="hang-role-active"
					name="hang_role_active"
					value="1"
					<?php checked( $active ); ?>
				/>
				<strong><?php esc_html_e( 'Role is active', 'han-group' ); ?></strong>
			</label>
			<br />
			<span class="description"><?php esc_html_e( 'Uncheck to close the role without deleting it.', 'han-group' ); ?></span>
		</p>
		<p>
			<label for="hang-role-location"><?php esc_html_e( 'Location', 'han-group' ); ?></label>
			<input
				type="text"
				id="hang-role-location"
				name="hang_role_location"
				value="<?php echo esc_attr( $location ); ?>"
				class="widefat"
				placeholder="<?php esc_attr_e( 'e.g. Glendale, CA', 'han-group' ); ?>"
			/>
		</p>
		<p>
			<label for="hang-role-salary-range"><?php esc_html_e( 'Salary Range', 'han-group' ); ?></label>
			<input
				type="text"
				id="hang-role-salary-range"
				name="hang_role_salary_range"
				value="<?php echo esc_attr( $salary ); ?>"
				class="widefat"
				placeholder="<?php esc_attr_e( 'e.g. $95,000 – $120,000', 'han-group' ); ?>"
			/>
		</p>
		<p>
			<label for="hang-role-type"><?php esc_html_e( 'Type', 'han-group' ); ?></label>
			<select id="hang-role-type" name="hang_role_type" class="widefat">
				<?php foreach ( hang_open_role_type_options() as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $type, $value ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="hang-role-nature"><?php esc_html_e( 'Nature', 'han-group' ); ?></label>
			<select id="hang-role-nature" name="hang_role_nature" class="widefat">
				<?php foreach ( hang_open_role_nature_options() as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $nature, $value ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="hang-role-match-rate"><?php esc_html_e( 'Match Rate', 'han-group' ); ?></label>
			<input
				type="text"
				id="hang-role-match-rate"
				name="hang_role_match_rate"
				value="<?php echo esc_attr( $match_rate ); ?>"
				class="widefat"
				placeholder="<?php esc_attr_e( 'e.g. 92', 'han-group' ); ?>"
			/>
		</p>
		<p>
			<label for="hang-role-apply-link"><?php esc_html_e( 'Apply Link', 'han-group' ); ?></label>
			<?php /* Deliberately type="text": type="url" makes the browser reject "#" and other scheme-less values. */ ?>
			<input
				type="text"
				id="hang-role-apply-link"
				name="hang_role_apply_link"
				value="<?php echo esc_url( $apply_link, array( 'http', 'https', 'mailto' ) ); ?>"
				class="widefat"
				placeholder="<?php esc_attr_e( 'https://example.com/apply, /careers/, or #apply', 'han-group' ); ?>"
			/>
		</p>
		<?php
	}
endif;


if ( ! function_exists( 'hang_save_open_role_meta' ) ) :
	/**
	 * Saves the Open Role meta fields.
	 *
	 * @param int $post_id Post ID.
	 */
	function hang_save_open_role_meta( $post_id ) {
		if (
			! isset( $_POST['hang_open_role_meta_nonce'] ) ||
			! wp_verify_nonce( sanitize_key( $_POST['hang_open_role_meta_nonce'] ), 'hang_save_open_role_meta' )
		) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$text_fields = array( 'hang_role_location', 'hang_role_salary_range', 'hang_role_match_rate' );

		foreach ( $text_fields as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}

		if ( isset( $_POST['hang_role_type'] ) ) {
			update_post_meta( $post_id, 'hang_role_type', hang_sanitize_open_role_type( sanitize_key( wp_unslash( $_POST['hang_role_type'] ) ) ) );
		}

		if ( isset( $_POST['hang_role_nature'] ) ) {
			update_post_meta( $post_id, 'hang_role_nature', hang_sanitize_open_role_nature( sanitize_key( wp_unslash( $_POST['hang_role_nature'] ) ) ) );
		}

		if ( isset( $_POST['hang_role_apply_link'] ) ) {
			update_post_meta( $post_id, 'hang_role_apply_link', sanitize_url( wp_unslash( $_POST['hang_role_apply_link'] ) ) );
		}

		// An unchecked checkbox posts nothing, so absence means off. The nonce
		// check above guarantees this really is a submission of that form.
		update_post_meta( $post_id, 'hang_role_active', isset( $_POST['hang_role_active'] ) );
	}
endif;
add_action( 'save_post_open-role', 'hang_save_open_role_meta' );


if ( ! function_exists( 'hang_flush_rewrite_rules_on_activation' ) ) :
	/**
	 * Flushes rewrite rules once when the theme is activated, so event and
	 * event type permalinks resolve without a manual visit to
	 * Settings → Permalinks.
	 *
	 * Team and Open Role are not registered here: neither has rewrite rules.
	 */
	function hang_flush_rewrite_rules_on_activation() {
		hang_register_event_post_type();
		hang_register_team_post_type();

		if ( function_exists( 'hang_register_event_type_taxonomy' ) ) {
			hang_register_event_type_taxonomy();
		}

		flush_rewrite_rules();
	}
endif;
add_action( 'after_switch_theme', 'hang_flush_rewrite_rules_on_activation' );


// ── Active toggle column on the Open Roles admin screen ───────────────────────

if ( ! function_exists( 'hang_open_role_is_active' ) ) :
	/**
	 * Whether a role is active.
	 *
	 * A role saved before this field existed has no stored value; those count
	 * as active, matching the field's default.
	 *
	 * @param  int $post_id Post ID.
	 * @return bool
	 */
	function hang_open_role_is_active( $post_id ) {
		if ( ! metadata_exists( 'post', $post_id, 'hang_role_active' ) ) {
			return true;
		}

		return (bool) get_post_meta( $post_id, 'hang_role_active', true );
	}
endif;


if ( ! function_exists( 'hang_open_role_columns' ) ) :
	/**
	 * Adds an "Active" column, placed just after the title.
	 *
	 * @param  array $columns Existing column definitions.
	 * @return array
	 */
	function hang_open_role_columns( $columns ) {
		$reordered = array();

		foreach ( $columns as $key => $label ) {
			$reordered[ $key ] = $label;

			if ( 'title' === $key ) {
				$reordered['hang_role_active'] = __( 'Active', 'han-group' );
			}
		}

		// If there was no title column to anchor to, fall back to appending.
		if ( ! isset( $reordered['hang_role_active'] ) ) {
			$reordered['hang_role_active'] = __( 'Active', 'han-group' );
		}

		return $reordered;
	}
endif;
add_filter( 'manage_open-role_posts_columns', 'hang_open_role_columns' );


if ( ! function_exists( 'hang_open_role_column_content' ) ) :
	/**
	 * Renders the toggle switch in the Active column.
	 *
	 * @param  string $column_name Column key.
	 * @param  int    $post_id     Post ID.
	 * @return void
	 */
	function hang_open_role_column_content( $column_name, $post_id ) {
		if ( 'hang_role_active' !== $column_name ) {
			return;
		}

		$active   = hang_open_role_is_active( $post_id );
		$disabled = ! current_user_can( 'edit_post', $post_id );

		/* translators: %s: role title. */
		$label = sprintf( __( 'Toggle whether %s is active', 'han-group' ), get_the_title( $post_id ) );
		?>
		<button
			type="button"
			class="hang-role-toggle"
			role="switch"
			aria-checked="<?php echo $active ? 'true' : 'false'; ?>"
			aria-label="<?php echo esc_attr( $label ); ?>"
			data-id="<?php echo esc_attr( (string) $post_id ); ?>"
			<?php disabled( $disabled ); ?>
		>
			<span class="hang-role-toggle__track" aria-hidden="true">
				<span class="hang-role-toggle__thumb"></span>
			</span>
		</button>
		<?php
	}
endif;
add_action( 'manage_open-role_posts_custom_column', 'hang_open_role_column_content', 10, 2 );


if ( ! function_exists( 'hang_open_role_admin_assets' ) ) :
	/**
	 * Loads the toggle script and styles on the Open Roles list table only.
	 *
	 * @param  string $hook Current admin page.
	 * @return void
	 */
	function hang_open_role_admin_assets( $hook ) {
		global $typenow;

		if ( 'edit.php' !== $hook || 'open-role' !== $typenow ) {
			return;
		}

		wp_enqueue_style(
			'hang-open-role-admin',
			get_theme_file_uri( 'assets/css/open-role-admin.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_script(
			'hang-open-role-toggle',
			get_theme_file_uri( 'assets/js/open-role-toggle.js' ),
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);

		wp_add_inline_script(
			'hang-open-role-toggle',
			'window.hangOpenRole = ' . wp_json_encode(
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'hang_open_role_toggle' ),
				)
			) . ';',
			'before'
		);
	}
endif;
add_action( 'admin_enqueue_scripts', 'hang_open_role_admin_assets' );


if ( ! function_exists( 'hang_toggle_open_role_active_ajax' ) ) :
	/**
	 * Flips the active flag for a single role.
	 *
	 * @return void
	 */
	function hang_toggle_open_role_active_ajax() {
		check_ajax_referer( 'hang_open_role_toggle', 'nonce' );

		$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

		if ( ! $post_id || 'open-role' !== get_post_type( $post_id ) ) {
			wp_send_json_error( array( 'message' => __( 'Unknown role.', 'han-group' ) ), 400 );
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_send_json_error( array( 'message' => __( 'You cannot edit this role.', 'han-group' ) ), 403 );
		}

		$active = isset( $_POST['active'] ) && '1' === $_POST['active'];

		update_post_meta( $post_id, 'hang_role_active', $active );

		wp_send_json_success( array( 'active' => $active ) );
	}
endif;
add_action( 'wp_ajax_hang_toggle_open_role_active', 'hang_toggle_open_role_active_ajax' );
