<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>

	<?php 
	
		$product_name = $product->get_name();
		$product_image = $product->get_image();	
		// $attachment_ids = $product->get_gallery_attachment_ids();
		$image_id  = $product->get_image_id();
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );

		// Fecha de evento (string)
		$product_fecha_timestamp = strtotime(get_field('fecha_de_evento'));
		$product_fecha = date_i18n( "D, M j, h:i A", $product_fecha_timestamp );
		$product_fecha_fin_timestamp = strtotime(get_field('fecha_de_evento_final'));
		if(!$product_fecha_fin_timestamp){
			$product_fecha_fin_timestamp = $product_fecha_timestamp;
		}

		// Tipo de evento. (array)
		$product_tipo_evento = get_field('tipo_de_evento');
		if($product_tipo_evento["value"] == "online"){
			$current_date = current_time('timestamp');
			if( $product_fecha_timestamp <= $current_date  && $current_date  <= $product_fecha_fin_timestamp ){
				$product_tipo_evento["value"] = "en-vivo";
				$product_tipo_evento["label"] = "En vivo";
			} 
		} elseif($product_tipo_evento["value"] == "presencial"){
			$product_tipo_evento["label"] = get_field('presencial_campus');
		}

		// Evento URL
		$product_url = $product->get_permalink();

		// Expositor
		$product_expositor = 'No defenido';

		// Modalidad
		$product_modalidad = get_field('tipo_de_evento')["label"];

	?>
	<a href="<?php echo $product_url ?>">
		<div class="c-header-card"  id="<?php echo $image_url ?>">
			<div class="productos-item__tag tipo-evento tipo_<?php echo $product_tipo_evento["value"] ; ?>">
				<span>
					<?php echo $product_tipo_evento["label"] ; ?>
				</span>
			</div>
			<div class="productos-item__imagen" style="background-image: url( <?php echo $image_url ?>)">
			</div>
		</div>
		<div  class="productos-item__body">
			<div class="productos-item__body__fecha"><?php echo $product_fecha; ?></div>
			<h3><?php echo $product_name; ?></h3>
			<div class="c-footer-card">
				<div class="productos-item__body__btn"><a href="<?php echo $product_url; ?>">Registrarme</a></div>
				<div class="productos-item__body__share">
					<a href="javascript:void(0);" class="share-btn modal-toggle" 
						data-ele_imagen="<?php echo $image_url; ?>"
						data-ele_titulo="<?php echo $product_name; ?>"
						data-ele_modalidad="<?php echo $product_modalidad; ?>"
						data-ele_fecha="<?php echo $product_fecha; ?>"
						data-ele_expositor="<?php echo $product_expositor; ?>"
						data-ele_link="<?php echo $product_url; ?>"
					>
						<img src="/wp-content/uploads/2021/01/share.svg" alt="share">
					</a>
				</div>
			</div>
			
		</div>
	</a>
</li>

<!-- <div class="jquery-modal"> -->
	<!---->
<!-- </div> -->
