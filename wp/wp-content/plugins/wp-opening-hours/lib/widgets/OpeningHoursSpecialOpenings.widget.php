<?
/**
 *	Opening Hours		– Special Openings Widget
 */

class Opening_Hours_Special_Openings extends WP_Widget {
	
	/**
	 *	Constructor
	 */
	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'widget_op_special_openings', 
			'description' 	=> op__('This Widget lists up all the Special Openings that you have set up in the Opening Hours Menu-Section.')
		);
	
		$this->WP_Widget('widget_op_special_openings', op__('Opening Hours: Special Openings'), $widget_ops);
		$this->alt_option_name = 'widget_op_special_openings';
	}
	
	/**
	 *	Widget Function
	 */
	function widget ( $args, $instance ) {
		extract ( $args );
		global	$wp_opening_hours;
		
		echo	$before_widget;
		
		/* Title Markup */
		if ( $instance['title'] )
			echo $before_title . $instance['title'] . $after_title;
			
		/* Body Markup */
		$show_name_col		= ( $instance['label-by'] == 'name' or $instance['label-by'] == 'both' );
		$show_date_col		= ( $instance['label-by'] == 'date' or $instance['label-by'] == 'both' );
		
		if ( count((array) $wp_opening_hours->specialOpenings ) ) :
		?>
        	<table class="op-table op-special-openings-table">
            	<tbody>
                <? foreach ($wp_opening_hours->specialOpenings as $special_opening) : ?>
                	<tr class="op-special-opening <? if ($instance['highlighted'] and $special_opening->isToday()) echo 'highlighted' ?>">
                    
                    <!-- Name Col -->
                    <? if ( $show_name_col ) : ?>
                    	<td class="op-special-opening-name">
                        	<? echo $special_opening->name ?>
                        </td>
                    <? endif ?>
                    
                    <!-- Date Col -->
                    <? if ( $show_date_col ) : ?>
                    	<td class="op-special-opening-date">
                        	<? echo date( op_get_setting('date-format'), $special_opening->start_ts ) ?>
                        </td>
                    <? endif ?>
                    
                    <!-- Time Col -->
                    	<td class="op-special-opening-time">
                        	<? echo date( op_get_setting('time-format'), $special_opening->start_ts ) ?> – <? echo date( op_get_setting('time-format'), $special_opening->end_ts ) ?>
                        </td>
                    </tr>
                <? endforeach ?>
                </tbody>
            </table>
        <?
		endif;
		
		echo	$after_widget;
	}
	
	/**
	 *	Update Function
	 */
	function update ($new_instance, $old_instance) {
		return $new_instance;
	}

	
	/**
	 *	Form Function
	 */
	function form ( $instance ) {
	?>
    	<p>
        	<label for="<? echo $this->get_field_id( 'title' ) ?>">
            	<? op_e('Title') ?>
           	</label>
            <input type="text" class="widefat" name="<? echo $this->get_field_name( 'title' ) ?>" id="<? echo $this->get_field_id( 'title' ) ?>" value="<? echo $instance['title'] ?>" />
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('highlighted') ?>">
            	<input type="checkbox" <? echo ($instance['highlighted']) ? 'checked="checked"' : '' ?> name="<? echo $this->get_field_name('highlighted') ?>" id="<? echo $this->get_field_id('highlighted') ?>" />
                <? op_e('Highlight today\'s Special Opening.') ?>
            </label>
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('label-by') ?>">
            	<? op_e('Label Special Openings by:') ?>
            </label>
            <select size="1" name="<? echo $this->get_field_name('label-by') ?>" id="<? echo $this->get_field_id('label-by') ?>">
            <?
				$options	= array(
					'name'		=> op__('Name'),
					'date'		=> op__('Date'),
					'both'		=> op__('Both')
				);
				
				foreach ($options as $value => $caption) :
					$selected		= ( $value == $instance['label-by'] ) ? 'selected="selected"' : '';
					echo	'<option value="'. $value .'" '. $selected .'>'. $caption .'</option>';
				endforeach;
			?>
            </select><br />
            <small><? op_e('Only choose "Both" when your widget area is wide enough') ?></small>
        </p>

    <?
	}

}
?>