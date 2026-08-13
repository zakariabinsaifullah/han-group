<?php
/**
 * Events Grid Shortcode
 *
 * Renders the Event post type as a card grid.
 *
 * Usage: [events_grid columns="3" per_page="6" type="webinar"]
 *
 * @package Han_Group
 */

// =============================================================================
// Asset enqueueing
// =============================================================================

if ( ! function_exists( 'hang_events_grid_enqueue_assets' ) ) :
	/**
	 * Loads the grid stylesheet. Called only when the shortcode renders.
	 */
	function hang_events_grid_enqueue_assets() {
		wp_enqueue_style(
			'hang-events-grid',
			get_theme_file_uri( 'assets/css/events-grid.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;


// =============================================================================
// Helpers
// =============================================================================

if ( ! function_exists( 'hang_events_grid_arrow_svg' ) ) :
	/**
	 * The trailing arrow used by the Learn More link.
	 *
	 * Filled with `currentColor` so it follows the link colour on hover, the
	 * same way the Link button variation's masked arrow does.
	 *
	 * @return string
	 */
	function hang_events_grid_arrow_svg() {
		return '<svg class="heg-card__more-icon" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">'
			. '<path d="m13.75 6.625-5.5 5.25c-.312.281-.781.281-1.062-.031s-.282-.781.03-1.063l4.157-3.969H.75a.72.72 0 0 1-.75-.75.74.74 0 0 1 .75-.75h10.625L7.219 1.376A.746.746 0 0 1 7.187.313.746.746 0 0 1 8.25.28l5.5 5.25c.156.157.25.344.25.532a.78.78 0 0 1-.25.562" fill="currentColor"/>'
			. '</svg>';
	}
endif;


if ( ! function_exists( 'hang_events_grid_get_summary' ) ) :
	/**
	 * Returns the card summary.
	 *
	 * A hand-written excerpt is used verbatim; otherwise the post content is
	 * trimmed to 25 words.
	 *
	 * @param WP_Post $post Event post.
	 * @return string
	 */
	function hang_events_grid_get_summary( $post ) {
		if ( ! empty( $post->post_excerpt ) ) {
			return $post->post_excerpt;
		}

		$content = strip_shortcodes( $post->post_content );
		$content = wp_strip_all_tags( $content );

		return wp_trim_words( $content, 25, '&hellip;' );
	}
endif;


if ( ! function_exists( 'hang_events_grid_render_card' ) ) :
	/**
	 * Renders one event card: image → (date | type + title) → summary → Learn More.
	 *
	 * @param int $post_id Event ID.
	 * @return string
	 */
	function hang_events_grid_render_card( $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post ) {
			return '';
		}

		$permalink = get_permalink( $post_id );
		$summary   = hang_events_grid_get_summary( $post );

		// Date stack. Uses the publish date — see the note in the file header.
		$timestamp = (int) get_post_timestamp( $post_id );
		$month     = wp_date( 'M', $timestamp );
		$day       = wp_date( 'd', $timestamp );
		$year      = wp_date( 'Y', $timestamp );
		$machine   = wp_date( 'Y-m-d', $timestamp );

		// First Type term.
		$terms     = get_the_terms( $post_id, 'event-type' );
		$type_name = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

		$html = '<article class="heg-card">';

		if ( has_post_thumbnail( $post_id ) ) {
			$html .= '<a class="heg-card__image" href="' . esc_url( $permalink ) . '" tabindex="-1" aria-hidden="true">';
			$html .= get_the_post_thumbnail( $post_id, 'large', array( 'loading' => 'lazy' ) );
			$html .= '</a>';
		}

		$html .= '<div class="heg-card__body">';

		// Two columns: date | type + title.
		$html .= '<div class="heg-card__head">';
		$html .= '<time class="heg-card__date" datetime="' . esc_attr( $machine ) . '">';
		$html .= '<span class="heg-card__month">' . esc_html( $month ) . '</span>';
		$html .= '<span class="heg-card__day">' . esc_html( $day ) . '</span>';
		$html .= '<span class="heg-card__year">' . esc_html( $year ) . '</span>';
		$html .= '</time>';

		$html .= '<div class="heg-card__headings">';
		if ( $type_name ) {
			$html .= '<span class="heg-card__type">' . esc_html( $type_name ) . '</span>';
		}
		$html .= '<h3 class="heg-card__title"><a href="' . esc_url( $permalink ) . '">' . esc_html( get_the_title( $post_id ) ) . '</a></h3>';
		$html .= '</div>';
		$html .= '</div>';

		if ( $summary ) {
			$html .= '<p class="heg-card__excerpt">' . esc_html( $summary ) . '</p>';
		}

		$html .= '<a class="heg-card__more" href="' . esc_url( $permalink ) . '">';
		$html .= '<span>' . esc_html__( 'Learn More', 'han-group' ) . '</span>';
		$html .= hang_events_grid_arrow_svg();
		$html .= '</a>';

		$html .= '</div>'; // .heg-card__body
		$html .= '</article>';

		return $html;
	}
endif;


// =============================================================================
// Shortcode
// =============================================================================

if ( ! function_exists( 'hang_events_grid_shortcode' ) ) :
	/**
	 * [events_grid columns="3" per_page="6" type="" order="DESC" orderby="date"]
	 *
	 * `columns`  — grid columns on desktop, 1-6 (default 3).
	 * `per_page` — how many events to show, 1-50 (default 6).
	 * `type`     — comma-separated event-type slugs or IDs; omit for all.
	 * `order`    — ASC or DESC (default DESC).
	 * `orderby`  — any WP_Query orderby value (default date).
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	function hang_events_grid_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'columns'  => 3,
				'per_page' => 6,
				'type'     => '',
				'order'    => 'DESC',
				'orderby'  => 'date',
			),
			$atts,
			'events_grid'
		);

		if ( ! post_type_exists( 'event' ) ) {
			return '';
		}

		$columns  = min( 6, max( 1, (int) $atts['columns'] ) );
		$per_page = min( 50, max( 1, (int) $atts['per_page'] ) );
		$order    = 'ASC' === strtoupper( (string) $atts['order'] ) ? 'ASC' : 'DESC';

		$args = array(
			'post_type'           => 'event',
			'post_status'         => 'publish',
			'posts_per_page'      => $per_page,
			'order'               => $order,
			'orderby'             => sanitize_key( $atts['orderby'] ),
			'ignore_sticky_posts' => true,
		);

		$type_tokens = array_filter( array_map( 'trim', explode( ',', (string) $atts['type'] ) ), 'strlen' );

		if ( $type_tokens && taxonomy_exists( 'event-type' ) ) {
			$numeric = array_filter( $type_tokens, 'is_numeric' );

			$args['tax_query'] = array(
				array(
					'taxonomy' => 'event-type',
					'field'    => count( $numeric ) === count( $type_tokens ) ? 'term_id' : 'slug',
					'terms'    => count( $numeric ) === count( $type_tokens )
						? array_map( 'absint', $type_tokens )
						: array_map( 'sanitize_title', $type_tokens ),
				),
			);
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			wp_reset_postdata();
			return '<p class="heg-empty">' . esc_html__( 'No events found.', 'han-group' ) . '</p>';
		}

		hang_events_grid_enqueue_assets();

		$html = '<div class="heg-grid" style="--heg-columns:' . (int) $columns . '">';

		while ( $query->have_posts() ) {
			$query->the_post();
			$html .= hang_events_grid_render_card( get_the_ID() );
		}

		$html .= '</div>';

		wp_reset_postdata();

		return $html;
	}
endif;
add_shortcode( 'events_grid', 'hang_events_grid_shortcode' );
