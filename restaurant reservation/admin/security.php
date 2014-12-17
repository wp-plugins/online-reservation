<?php
/*
	TABLE OF CONTENTS ( SECURITY TAB )
	=======================================
	1.	ADVANCE SECURITY
*/
?>
	<h2>Protect Your System From Fake Bookings </h2>
    <p>
    	Although our system is built with many considerations associated with fake bookings and online fraud that might happen, 
        But We strongly recommend you to enable advance security , where this features enable our system to integrate with the third party system,
       	for giving your more Safety against fake bookings and online fraud .
    </p>
    <br/ >
    
	<?php //= 1.	ADVANCE SECURITY ?>
    <label for="advance_security" class="label"><?php _e('Advance Security',PLUGIN_NAME); ?></label>    
	<input type="checkbox" id="advance_security" name="resto_all_setting[advance_security]" value="1" <?php checked('1', $options['advance_security']) ?> />
	<p class="float-none"></p>
    <br/>