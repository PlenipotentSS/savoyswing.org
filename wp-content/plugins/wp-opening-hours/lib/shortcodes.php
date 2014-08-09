<?
/**
 *	Opening Hours Shortcodes
 */
 
/**
 *	Is Open Shortcode
 */
function op_shortcode_is_open ($atts) {
	
	/* Extract Attributes */
	extract(shortcode_atts( array(
		'caption_open'		=> apply_filters( 'op_status_shortcode_default_open', op__('We\'re currently open') ),
		'caption_closed'	=> apply_filters( 'op_status_shortcode_default_closed', op__('We\'re currently closed') )
	), $atts, apply_filters( 'op_status_shortcode_key', 'is-open' )));
	
	/* Return right string */
	return	apply_filters( 
		'op_status_shortcode_output', 
		(is_open())	
			? apply_filters( 'op_status_shortcode_open', $caption_open ) 
			: apply_filters( 'op_status_shortcode_closed', $caption_closed ) 
		);
}

/**
 *	Register Shortcode
 */
add_shortcode (apply_filters( 'op_status_shortcode_key', 'is-open' ), 'op_shortcode_is_open');
?>