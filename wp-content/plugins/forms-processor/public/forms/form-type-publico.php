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


$integracion_zoom = get_field('integracion_zoom', get_the_id());
$zoom_meeting_id = '';
if($integracion_zoom){
  if($integracion_zoom['zoom_integracion_estado']){
    $zoom_meeting_id = $integracion_zoom['zoom_meeting_id'];
  }
}

?>

  <form id="form-event-register_publico">
    <div class="row" >
      <div class="col-12 col-md-6">
        <input type="text" name="reg_nombre" placeholder="Nombres:">
      </div>
      <div class="col-12 col-md-6">
        <input type="text" name="reg_ape_paterno" placeholder="Apellido paterno:">
      </div>
    </div>
    <div class="row" >
      <div class="col-12 col-md-6">
        <input type="text" name="reg_ape_materno" placeholder="Apellido materno:">
      </div>
      <div class="col-12 col-md-6">
        <select name="reg_genero">
          <option>Género</option>
          <option>Masculino</option>
          <option>Femenino</option>
        </select> 
      </div>
    </div>
    <div class="row" >
      <div class="col-12 col-md-6">
        <select name="reg_tipo_doc">
          <option>Tipo de documento</option>
          <option>DNI</option>
          <option>CE</option>
        </select> 
      </div>
      <div class="col-12 col-md-6">
        <input type="text" name="reg_num_doc" placeholder="Número de documento:">
      </div>
    </div>
    <div class="row" >
      <div class="col-12 col-md-6">
        <input type="text" name="reg_email" placeholder="Email:">
      </div>
      <div class="col-12 col-md-6">
        <input type="text" name="reg_celular" placeholder="Celular:">
      </div>
    </div>
    <div class="row mt-1 mb-1">
      <div class="col-12 flex-label">
        <input type="radio" name="reg_autorizacion" value="si" id="authorization_yes"> 
        <label class="form-check-label" for="authorization_yes">
        Al enviar la información confirmo haber leído y acepto los términos y condiciones acerca del tratamiento de mis datos personales.</label>
        
      </div>
      <div class="col-12 flex-label">
        <input type="radio" name="reg_autorizacion" value="" id="authorization_no" checked="checked"> 
        <label for="authorization_no">No autorizo</label>
      </div>
    </div>
    <div class="row" style="display: flex;">
      <div class="col btn-submit-event">
        <input type="hidden" name="hidden_evento_id" value="<?php echo get_the_id(); ?>">
        <input type="hidden" name="hidden_zoom_meeting_id" value="<?php echo $zoom_meeting_id; ?>">
        <input type="submit" class="sso-btn" value="Registrarme">
      </div>
    </div>
  </form>