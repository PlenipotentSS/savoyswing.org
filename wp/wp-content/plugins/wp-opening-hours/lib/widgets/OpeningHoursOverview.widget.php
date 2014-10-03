<?
/**
 *	Opening Hours		– Overview Widget
 */
 
class Opening_Hours_Overview extends WP_Widget {
	
	/**
	 *	Constructor
	 */
	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'widget_op_overview', 
			'description' 	=> op__('This Widgets displays an overview of your Opening Hours in the corresponding Sidebar')
		);
	
		$this->WP_Widget('widget_op_overview', op__('Opening Hours Overview'), $widget_ops);
		$this->alt_option_name = 'widget_op_overview';
		
		$this->defaults = array(
			'title'				=> apply_filters( 'op_overview_widget_default_title', op__('Opening Hours') ),
			'caption-closed'	=> apply_filters( 'op_overview_widget_default_closed', op__('Closed') )
		);
	}
	
	/**
	 *	Widget Function
	 */
	function widget ($args, $instance) {
		extract ( $args );
		
		/* Set default Values */
		$instance	= self::setup_defaults( $instance );
		
		/* Initialize $wp_opening_hours */
		global $wp_opening_hours;
		if (!is_object($wp_opening_hours))	$wp_opening_hours	= new OpeningHours;
		
		echo $before_widget;
		
		/* Title Markup */
		echo $before_title;
		echo apply_filters( 'op_overview_widget_title', $instance['title'] );
		echo $after_title;
		
		/* Body Markup */	
		if ( $wp_opening_hours->numberPeriods() or $insance['show-closed'] ) :		// If there are any Periods or if the "Show Closed" option is activated
		?>
			<table class="op-table op-overview-table">
            <? 
				foreach ($wp_opening_hours->allDays() as $key => $periods) : 		// Each day
				if (count( $periods ) or $instance['show-closed']) :
			?>
            	<tr class="op-overview-row <? echo ($instance['highlight'] == 'day' and $key == strtolower(date('l', current_time('timestamp')))) ? 'highlighted' : '' ?>">
                	<th class="op-overview-title">
                    	<? echo apply_filters( 'op_overview_widget_weekday', $wp_opening_hours->weekdays[ $key ] ) ?>
                    </th>
                    <td class="op-overview-times">
                    <? if (is_array( $periods ) and count( $periods )) : ?>
						<? foreach ($periods as $period) : ?>
                            <div class="op-overview-set <? echo ($instance['highlight'] == 'period' and $period->isRunning()) ? 'highlighted' : '' ?>">
                                <? echo apply_filters( 'op_overview_widget_time_string', timeString( array(
									'start'		=> $period->start_ts,
									'end'		=> $period->end_ts
								) ) );
								?>
                            </div>
                        <? endforeach ?>
                    <? else : ?>
                    	<div class="op-overview-set closed">
                        	<? echo apply_filters( 'op_overview_widget_closed', $instance['caption-closed'] ) ?>
                        </div>
                    <? endif ?>
                    </td>
                </tr>
            <?
				endif; 
				endforeach ;
			?>
            </table>
        <?
		endif;
		
		echo $after_widget;
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
	function form ($instance) {
	?>
    	<p>
        	<label for="<? echo $this->get_field_id('title') ?>">
            	<? op_e('Title') ?>
            </label>
            <input type="text" value="<? echo $instance['title'] ?>" name="<? echo $this->get_field_name('title') ?>" id="<? echo $this->get_field_id('title') ?>" placeholder="<? echo $this->defaults['title'] ?>" class="widefat" />
        </p>
                
        <p>
        	<label for="<? echo $this->get_field_id('show-closed') ?>">
            	<input type="checkbox" <? echo ($instance['show-closed']) ? 'checked="checked"' : '' ?> name="<? echo $this->get_field_name('show-closed') ?>" id="<? echo $this->get_field_id('show-closed') ?>" />
                <? op_e('Also show closed days') ?>
            </label>
        </p>
        
    	<p id="op-overview-caption-closed">
        	<label for="<? echo $this->get_field_id('caption-closed') ?>">
            	<? op_e('Caption for "closed"-label') ?>
            </label>
            <input type="text" value="<? echo $instance['caption-closed'] ?>" name="<? echo $this->get_field_name('caption-closed') ?>" id="<? echo $this->get_field_id('caption-closed') ?>" placeholder="<? echo $this->defaults['caption-closed'] ?>" class="widefat" />
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('highlight') ?>">
            	<? op_e('Highlight:') ?>
            </label>
            
            <select class="widefat" name="<? echo $this->get_field_name('highlight') ?>" id="<? echo $this->get_field_id('highlight') ?>">
            <?
				$highlight_opts		= array(
					'nothing'		=> op__('nothing'),
					'period'		=> op__('running period'),
					'day'			=> op__('current day')
				);
				
				foreach ($highlight_opts as $slug => $caption) :
				?>
                	<option value="<? echo $slug ?>" <? echo ($instance['highlight'] == $slug) ? 'selected="selected"' : '' ?>>
                    	<? echo $caption ?>
                    </option>
                <?
				endforeach;
			?>
            </select>
        </p>
    <?
	}
	
	/**
	 *	Helper:	Set default values if not set by user
	 */
	function setup_defaults( $instance = array() ) {
		foreach ($this->defaults as $key => $caption) :
			if (empty($instance[ $key ]))	$instance[ $key ]	= $caption;
		endforeach;
		
		return $instance;
	}
	
}
?>