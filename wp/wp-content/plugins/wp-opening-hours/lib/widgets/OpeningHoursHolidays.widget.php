<?
/**
 *	Opening Hours	– Holidays Widget
 */
 
class Opening_Hours_Holidays extends WP_Widget {
	
	/**
	 *	Constructor
	 */
	function __construct() {
		$widget_opts = array(
			'classname'		=> 'widget_op_holidays',
			'description'	=> op__('This Widget lists up all Holidays set up in the Opening Hours Section.')
		);	
		
		$this->WP_Widget('widget_op_holidays', op__('Opening Hours Holidays'), $widget_opts);
		$this->alt_option_name	= 'widget_op_holidays';
	}
	
	/**
	 *	Widget Function
	 */
	function widget ($args, $instance) {
		extract ($args);
		global $wp_opening_hours;
		
		echo $before_widget;
		
		/* Title Markup */
		if ($instance['title']) :
			echo $before_title;
			echo apply_filters('op_holidays_widget_title', $instance['title']);
			echo $after_title;
		endif;
		
		/* Sort Holidays */
		$holidays		= array();
		foreach ($wp_opening_hours->holidays as $holiday) :
			$holidays[ $holiday->start_ts ]		= $holiday;
		endforeach;
		
		ksort( $holidays );
		
		/* Body Markup */
		if (count($holidays)) :
		?>
			<table class="op-table op-holidays-table">
            <?	foreach ($holidays as $holiday) : ?>
            	<tr class="op-holiday <? if ($instance['highlighted'] and $holiday->isRunning()) echo 'highlighted' ?>">
                	<th>
                    	<? echo apply_filters( 'op_holidays_widget_name', $holiday->name ) ?>
                    </th>
                    <td>
                    	<? echo apply_filters( 'op_holidays_widget_date_string', dateString( array(
							'start'		=> $holiday->start_ts,
							'end'		=> $holiday->end_ts
						) ) )
						?>
                    </td>
                </tr>
            <?	endforeach; ?>
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
            <input type="text" name="<? echo $this->get_field_name('title') ?>" id="<? echo $this->get_field_id('title') ?>" value="<? echo $instance['title'] ?>" class="widefat" />
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('highlighted') ?>">
            	<input type="checkbox" <? echo ($instance['highlighted']) ? 'checked="checked"' : '' ?> name="<? echo $this->get_field_name('highlighted') ?>" id="<? echo $this->get_field_id('highlighted') ?>" />
                <? op_e('Highlight currently running Holidays.') ?>
            </label>
        </p>
	<?
	}
	
}
?>