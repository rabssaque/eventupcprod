<?php

/**
 * Provide form template for register
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/public/forms
 */

?>

  
    <div class="row" style="display: flex;">
      <!--div class="col btn-submit-event">
        <input type="hidden" name="hidden_evento_id" value="<?php echo get_the_id(); ?>">
        <input type="hidden" name="hidden_zoom_meeting_id" value="<?php echo $zoom_meeting_id; ?>">
        <input type="submit" value="Registrarme">
      </div-->
      <div id="sso-container">
      	<button 
          id="sso-btn-enrollment"
          class='sso-btn'
          data-evento-id="<?php echo get_the_id(); ?>"
          data-zoom-meeting-id="<?php echo $zoom_meeting_id; ?>"
          >Acceder</button>
      </div>
    </div>
 