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

  <form id="form-event-register_comunidad">
    <div class="row" style="display: flex;">
      <div class="col">
        <input type="text" name="reg_usuario_upc" placeholder="Usuario UPC:">
      </div>
      <div class="col">
        <input type="text" name="reg_email_upc" placeholder="Correo:">
      </div>
    </div>
    <div class="row" style="display: flex;">
      <div class="col btn-submit-event">
        <input type="hidden" name="hidden_evento_id" value="<?php echo get_the_id(); ?>">
        <input type="hidden" name="hidden_zoom_meeting_id" value="<?php echo $zoom_meeting_id; ?>">
        <input type="submit" value="Registrarme">
      </div>
    </div>
  </form>