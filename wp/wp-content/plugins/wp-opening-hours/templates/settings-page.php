<?
/**
 *	Backend Options Page: Settings
 */
 
 if (!is_object($wp_opening_hours))		$wp_opening_hours	= new OpeningHours;
 
 if ($_POST['op-action']	== 'save') :	// If user has intended to save the settings
 
 	// Apply changed settings
 	$wp_opening_hours->applySettings( array(
		'time-format'			=> $_POST['op-time-format'],
		'date-format'			=> $_POST['op-date-format']
	) );
	
 endif;
 global $op_facebook;
 
?>

<div class="wrap">

	 <?	screen_icon('options-general') ?>

	<h2>
    	<? op_e('Settings') ?>
    </h2>
    
    <form method="post">
                
        <h3>
            <? op_e('Time Format') ?>
        </h3>
    
    	<table class="form-table">
        	<tr>
            	<th>
                	<label for="op-time-format">
						<? op_e('Choose a time format') ?>
                    </label>
                </th>
                <td>
                <?
					$timeFormats	= array( // format => example
						'H:i'		=> '17:00',
						'Hi'		=> '1700',
						'g:ia'		=> '5:00pm',
					);
					
					$i = 0;
					foreach ($timeFormats as $format => $example) :
					?>
                    <label for="op-time-format-<? echo $i ?>">
                    	<input type="radio" name="op-time-format" id="op-time-format-<? echo $i ?>" value="<? echo $format ?>"
                        <? if (op_get_setting( 'time-format' ) == $format or (!op_get_setting( 'time-format' ) and $i == 0))
							echo 'checked="checked"' ?> />
                        <code><? echo $example ?></code>
                    </label><br />
                    <?
					$i++;
					endforeach;
				?>
                <label for="op-time-format-custom">
                	<input type="radio" name="op-time-format" id="op-time-format-custom" value="" />
                    	<? op_e('Insert your own time-format.') ?>
                        <a href="http://bit.ly/16Wsegh" target="_blank"><? op_e('Read more') ?></a>:
                </label>&nbsp;
                <input type="text"	class="small-text" id="op-time-format-custom-format" value="<? echo op_get_setting( 'time-format' ) ?>" />

                </td>
            </tr>
        </table>

        <h3>
            <? op_e('Date Format') ?>
        </h3>
    
    	<table class="form-table">
        	<tr>
            	<th>
                	<label for="op-date-format">
						<? op_e('Choose a date format') ?>
                    </label>
                </th>
                <td>
                <?
					$dateFormats	= array( // format => example
						'd.m.Y'		=> '02.03.2013',
						'j.n.Y'		=> '2.3.2013',
						'm/d/Y'		=> '03/02/2013',
						'jS M Y'	=> '2nd Feb 2013'
					);
					
					$i = 0;
					foreach ($dateFormats as $format => $example) :
					?>
                    <label for="op-date-format-<? echo $i ?>">
                    	<input type="radio" name="op-date-format" id="op-date-format-<? echo $i ?>" value="<? echo $format ?>"
                        <? if (op_get_setting( 'date-format' ) == $format or (!op_get_setting( 'date-format' ) and $i == 0))
							echo 'checked="checked"' ?> />
                        <code><? echo $example ?></code>
                    </label><br />
                    <?
					$i++;
					endforeach;
				?>
                <label for="op-date-format-custom">
                	<input type="radio" name="op-date-format" id="op-date-format-custom" value="" />
                    	<? op_e('Insert your own date-format.') ?>
                        <a href="http://bit.ly/16Wsegh" target="_blank"><? op_e('Read more') ?></a>:
                </label>&nbsp;
                <input type="text"	class="small-text" id="op-date-format-custom-format" value="<? echo op_get_setting( 'date-format' ) ?>" />

                </td>
            </tr>
        </table>
  
    <input type="hidden" name="op-action" value="save" />    
    
    <p class="submit">
        <input type="submit" class="button button-primary button-large" value="<? op_e('Save Changes') ?>" />
    </p>

    </form>

</div>

<script type="text/javascript">
	jQuery('#op-date-format-custom-format').change(function(e) {
        jQuery('#op-date-format-custom').val( 
			jQuery(this).val() 
		);
    });
	
	jQuery('#op-time-format-custom-format').change(function(e) {
        jQuery('#op-time-format-custom').val( 
			jQuery(this).val() 
		);
    });
</script>