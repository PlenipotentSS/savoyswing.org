<?
/**
 *	Opening Hours 	– Status Widget
 */
 
class Opening_Hours_Status extends WP_Widget {

	/**
	 *	Constructor
	 */
	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'widget_op_status', 
			'description' 	=> op__('This Widgets displays information in your sidebar, wether your venue is closed or open.')
		);
	
		$this->WP_Widget('widget_op_status', op__('Opening Hours Status'), $widget_ops);
		$this->alt_option_name = 'widget_op_status';
		
		$this->defaults = array(
			'caption-open'				=> apply_filters( 'op_status_widget_default_open', op__('We\'re currently open.') ),
			'caption-closed'			=> apply_filters( 'op_status_widget_default_closed', op__('We\'re currently closed.') ),
			'caption-closed-holiday'	=> apply_filters( 'op_status_widget_default_closed_holiday', op__('We\'re currently on holiday.') )
		);
	}
	
	/**
	 *	Widget Function
	 */
	function widget ($args, $instance) {
		extract ($args);
		
		/* Set default values */		
		$instance	= self::setup_defaults( $instance );
		
		echo $before_widget;
		
		/* Title Markup */
		if ($instance['title'])	:
			echo $before_title;
			echo apply_filters( 'op_status_widget_title', $instance['title'] );
			echo $after_title;
		endif;
		
		/* Body Markup */
		$is_open		= is_open( true ); 
		?>
        	<div class="op-status-label <? echo ($is_open[0]) ? 'open' : 'closed' ?> <? if (!$is_open[0]) echo 'closed-' . $is_open[1] ?>">
            	<?
				
				if ($is_open[0]) :
					$message	= apply_filters( 'op_status_widget_open', $instance['caption-open'] );
				else :
					$message	= ($is_open[1] == 'holiday') 
						? apply_filters( 'op_status_widget_closed_holiday', $instance['caption-closed-holiday'] ) 
						: apply_filters( 'op_status_widget_closed', $instance['caption-closed'] );
				endif;
				
				echo apply_filters (
					'op_status_widget_output',
					$message
				)
				?>
            </div>
        <?
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
            <input type="text" class="widefat" name="<? echo $this->get_field_name('title') ?>" id="<? echo $this->get_field_id('title') ?>" value="<? echo $instance['title'] ?>" />
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('caption-open') ?>">
            	<? op_e('Custom open-message') ?>
            </label>
            <input type="text" class="widefat" name="<? echo $this->get_field_name('caption-open') ?>" id="<? echo $this->get_field_id('caption-open') ?>" value="<? echo $instance['caption-open'] ?>" placeholder="<? echo $this->defaults['caption-open'] ?>" />
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('caption-closed') ?>">
            	<? op_e('Custom closed-message') ?>
            </label>
            <input type="text" class="widefat" name="<? echo $this->get_field_name('caption-closed') ?>" id="<? echo $this->get_field_id('caption-closed') ?>" value="<? echo $instance['caption-closed'] ?>" placeholder="<? echo $this->defaults['caption-closed'] ?>" />
        </p>
        
        <p>
        	<label for="<? echo $this->get_field_id('caption-closed-holiday') ?>">
            	<? op_e('Custom closed-holiday-message') ?>
            </label>
            <input type="text" class="widefat" name="<? echo $this->get_field_name('caption-closed-holiday') ?>" id="<? echo $this->get_field_id('caption-closed-holiday') ?>" value="<? echo $instance['caption-closed-holiday'] ?>" placeholder="<? echo $this->defaults['caption-closed-holiday'] ?>" />
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