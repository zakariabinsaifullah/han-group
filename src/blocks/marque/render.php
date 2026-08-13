<?php
/**
 * Marquee block render template.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner block content.
 * @var WP_Block $block      Block instance.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Set defaults and sanitize attributes.
$speed          = isset( $attributes['speed'] ) ? max( 1, intval( $attributes['speed'] ) ) : 30;
$gap            = isset( $attributes['gap'] ) ? max( 0, intval( $attributes['gap'] ) ) : 40;
$height         = isset( $attributes['height'] ) ? max( 200, intval( $attributes['height'] ) ) : 500;
$pause_on_hover = ! empty( $attributes['pauseOnHover'] );

// Constrain to known values so they can never leak into the style attribute.
$orientation = ! empty( $attributes['orientation'] ) ? sanitize_text_field( $attributes['orientation'] ) : 'horizontal';
$orientation = in_array( $orientation, array( 'horizontal', 'vertical' ), true ) ? $orientation : 'horizontal';

$direction = ! empty( $attributes['direction'] ) ? sanitize_text_field( $attributes['direction'] ) : 'left';
$direction = in_array( $direction, array( 'left', 'right', 'up', 'down' ), true ) ? $direction : 'left';

// Render inner blocks once; the second track is a duplicate for the seamless loop.
$inner_blocks_content = '';
if ( ! empty( $block->inner_blocks ) ) {
	foreach ( $block->inner_blocks as $inner_block ) {
		$inner_blocks_content .= $inner_block->render();
	}
}

// Wrapper: hand class/style to core so they merge with the block-supports output
// instead of emitting a second, ignored style attribute.
$wrapper_args = array(
	'class' => 'hang-marquee-wrapper marquee-' . $orientation,
);
if ( 'vertical' === $orientation ) {
	$wrapper_args['style'] = 'height:' . $height . 'px;';
}

// Container classes.
$container_classes = array( 'marquee-container', 'marquee-' . $orientation );
if ( $pause_on_hover ) {
	$container_classes[] = 'pause-on-hover';
}

// Determine animation name based on orientation and direction.
if ( 'vertical' === $orientation ) {
	$animation_name = in_array( $direction, array( 'left', 'up' ), true )
		? 'hang-marquee-scroll-up'
		: 'hang-marquee-scroll-down';
} else {
	$animation_name = in_array( $direction, array( 'right', 'down' ), true )
		? 'hang-marquee-scroll-right'
		: 'hang-marquee-scroll-left';
}

$container_style = sprintf(
	'--hang-marquee-duration:%1$ds;--hang-marquee-animation:%2$s;--hang-marquee-gap:%3$dpx;',
	$speed,
	$animation_name,
	$gap
);

// The leading track carries trailing space so the loop seam matches the item gap.
if ( 'horizontal' === $orientation ) {
	$content_style_first = sprintf( 'gap:%1$dpx;padding-right:%1$dpx;', $gap );
} else {
	$content_style_first = sprintf( 'gap:%1$dpx;padding-bottom:%1$dpx;', $gap );
}
$content_style_second = sprintf( 'gap:%dpx;', $gap );

?>
<div <?php echo get_block_wrapper_attributes( $wrapper_args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by core. ?>>
	<div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>" style="<?php echo esc_attr( $container_style ); ?>">
		<div class="marquee-content" style="<?php echo esc_attr( $content_style_first ); ?>">
			<?php echo $inner_blocks_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inner blocks escape their own render output. ?>
		</div>
		<div class="marquee-content" aria-hidden="true" style="<?php echo esc_attr( $content_style_second ); ?>">
			<?php echo $inner_blocks_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see above. ?>
		</div>
	</div>
</div>
