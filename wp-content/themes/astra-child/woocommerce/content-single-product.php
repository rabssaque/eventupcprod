<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

// Estado del evento
$evento_vencido = false;
// Stock 
$stock_available = 0;
if($product->get_manage_stock() && $product->is_in_stock()){
	$stock_available = $product->get_stock_quantity();
}

// Muestra/oculta banner. (boolean)
$banner_activo = get_field('banner_activo');

// Obtiene la imagen de banner. Requiere que el banner este activo. (array)
$banner_img_object = get_field('banner_imagen');

// Fecha de evento (string)
$fecha_evento_timestamp = strtotime(get_field('fecha_de_evento'));
$fecha_evento_dia = date_i18n( "j", $fecha_evento_timestamp );
$fecha_evento_mes_anio = date_i18n( "F Y", $fecha_evento_timestamp );
$fecha_evento = $fecha_evento_dia . " de ". $fecha_evento_mes_anio;

$fecha_fin_timestamp = strtotime(get_field('fecha_de_evento_final'));
if(!$fecha_fin_timestamp){
	$fecha_fin_timestamp = $fecha_evento_timestamp;
}
$fecha_google = date("Ymd\THis", $fecha_evento_timestamp)."/".date("Ymd\THis", $fecha_fin_timestamp);
$fecha_outlook = date("Y-m-d\TH:i:s", $fecha_evento_timestamp)."&enddt=".date("Y-m-d\TH:i:s", $fecha_fin_timestamp);

// Tipo de evento. (array)
$tipo_evento = get_field('tipo_de_evento');
if($tipo_evento["value"] == "online"){

	$current_date = current_time('timestamp');

	if( $fecha_evento_timestamp <= $current_date  && $current_date  <= $fecha_fin_timestamp ){
		$tipo_evento["value"] = "en-vivo";
		$tipo_evento["label"] = "En vivo";
	} elseif ( $fecha_fin_timestamp <= $current_date ) {
		$evento_vencido = true;
	}
}
if($tipo_evento["value"] == "presencial"){
	$tipo_evento["label"] = get_field('presencial_campus');
}



// Descripcion del evento
$descripcion_evento = get_field('descripcion_del_evento');

// tags de eventos
$tags_array = get_the_terms($product->get_id(), 'product_tag');

// Formulario
$form_type_obs = array();

if(!$evento_vencido){
	$form_type_obs_first = true;
	$form_type = get_field('formulario_de_evento');
	if($form_type){
		foreach ($form_type as $index => $value) {
			$form_type_obs[$value] = array('show' => true, 'class_tab' => "", 'class_body' => "");
			$form_type_obs[$value]['class_tab'] = ($form_type_obs_first) ? 'active-tab' : '';		
			$form_type_obs[$value]['class_body'] = ($form_type_obs_first) ? 'active-tab' : '';
			$form_type_obs_first = false;
		}
	}
}


// Muestra/oculta banner. (boolean)






/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?> >

<?php
	// Banner de evento
	if($banner_activo){ ?>

		<section class="product-banner">

			<img src="<?php echo $banner_img_object["url"]; ?>" alt="evento_banner">
			
		</section>

<?php } ?>
		
		
	<section class="space-sec">	

		<div class="container">
			<div class="row  c-dscrption" >
				<div class="col">
					<div class="tipo-evento  tipo_<?php echo $tipo_evento["value"] ; ?>">
						<span>
							<?php echo $tipo_evento["label"] ; ?>
						</span>
					</div>
					<div class="fecha-titulo">
						<span><?php echo $fecha_evento; ?></span>
						<h1><?php echo get_the_title(); ?></h1>
					</div>
					<div class="descripcion">
						<div><?php echo get_the_content(); ?></div>
						<div class="mt-1"><?php echo $descripcion_evento; ?></div>
					</div>
					<div class="tags">	
					    <?php
					    	if($tags_array){
					    		foreach ($tags_array as $product_tag) {
					    			echo "<span>".$product_tag->name."</span>";
					    		}
					    	}
					    ?>
					</div>
					<div class="compartir mb-2">
						Compartir este evento: 
						<a class="eupc-share" data-red="fb" href="<?php echo get_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/fb.svg" alt="fb"></a>
						<a class="eupc-share" data-red="ln" href="<?php echo get_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/linkedin-9.svg" alt="Ln"></a>
						<a class="eupc-share" data-red="tw" href="<?php echo get_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/twitter-9.svg" alt="tw"></a>
						<a class="eupc-share" data-red="wp" href="<?php echo get_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/whatsapp-9.svg" alt="wsp"></a>

					</div>
				</div>
				<div class="col ">
					<div class="colum-form">
						<div id="eupc-forms-gracias" class="msg-gracias" style="display: none;">
							<div class="msg">
								<div class="flama"><img src="https://valeriavalles.github.io/viveferia/assets/images/logoupc.png" alt="logo"></div>
								<h3>Gracias por inscribirte</h3>
								<p class="bold-msg">Te esperamos en la charla virtual <br> <?php echo $fecha_evento; ?></p>
								<p>Agrega el evento a tu calendario</p>
								<div>
									<a href="https://outlook.live.com/owa/?path=/calendar/action/compose&rru=addevent&startdt=<?php echo $fecha_outlook; ?>&subject=<?php echo get_the_title(); ?>&body=<?php echo get_the_title(); ?>" target="_blank"><i><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/calendar-outlook.svg" alt="icon" />Outlook/iCal</i></a>
									<a href="https://www.google.com/calendar/render?action=TEMPLATE&text=<?php echo get_the_title(); ?>&dates=<?php echo $fecha_google; ?>&details=<?php echo get_the_title(); ?>&location=&sf=true&output=xml" target="_blank"><i><img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/calendar-google.svg" alt="icon" />Google Calendar</i></a> </div>
							</div>
						</div>
					<div id="eupc-forms" class="form-registro">
						<?php if(count($form_type_obs) > 0 && !$evento_vencido && $stock_available > 0 ){ ?>
						<h3 class="mt-1 mb-1">Regístrate al evento</h3>
						<div clas='tabs'>
							<?php  if(count($form_type_obs) > 1){ ?>
								<ul class="tab-titulos">
								<?php 
									if($form_type){
										if(isset($form_type_obs['general'])){ ?>
											<li class="active-tab-form  <?php echo $form_type_obs['general']['class_tab']; ?>" data-tab="publico">Publico general</li>
									<?php } ?>
									<?php if(isset($form_type_obs['comunidad'] )){ ?>	
											<li class=" <?php echo $form_type_obs['comunidad']['class_tab']; ?>" data-tab="comunidad">Comunidad UPC</li>
									<?php } 
									}
								?>
								</ul>
							<?php } ?>
							<div class="tab-cuerpo">
							<?php if ($form_type) { ?>

								<?php if (isset($form_type_obs['general'])) { ?>

								<div class="tab-cuerpo_publico <?php echo $form_type_obs['general']['class_body']; ?>" id="publico">	
									
									<?php echo do_shortcode("[register_form form_type='publico']"); ?>

								</div>
								<?php } ?>
								<?php if (isset($form_type_obs['comunidad'])) { ?>
								<div class="tab-cuerpo_general <?php echo $form_type_obs['comunidad']['class_body']; ?>" id="comunidad">	
									
									<?php echo do_shortcode("[sso_login_form]"); ?>

								</div>
								<?php } ?>
							<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div><!-- Eventos From -->
					</div>
					
				</div>
			</div>
		</div>

	</section>
	<!-- Sección video || Imagen && Description -->
	<?php
	// Banner de evento
	$group_video = get_field('evento_contenido_video');
	
	if($group_video){
		if($group_video['mostrar_video']){ 
		?>
		<section class="space-sec mt-2 mb-2">
			<div class="container">
				<div class="row">
					<iframe src="<?php echo $group_video['url_video']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
				</div>			
			</div>				
		</section>

	<?php 
	} } 
	?>

	<?php
	// Descripcion larga
	$group_descripcion_larga = get_field('evento_descripcion_larga');
	if($group_descripcion_larga){
		if($group_descripcion_larga['mostrar_descripcion_larga']){ 
		
	?>
		<section class="space-sec c-description-foto mt-2 mb-2">
			<div class="container">
					<div class="row">
						<div>
							<?php echo $group_descripcion_larga['descripcion_larga']; ?>
						</div>
					</div>			
			</div>				
		</section>

	<?php 
	} } 
	?>
	
	<?php
	// Speakers
	$evento_speakers = get_field('lista_de_speakers');
	if($evento_speakers){
		if(count($evento_speakers) > 0){ 
	?>
	<section class="space-sec">
		<!-- Speakers  -->
		
		<div class="container">
			<div class="row">
				<div class="col p-0">
				<h2>Speakers</h2>
				<div class="content-items-speaker">
				<?php
					foreach($evento_speakers as $speaker) { ?>

							<div class="item-speaker">
								<div>
									<img src="<?php echo $speaker['foto']['url']; ?>" alt="<?php echo $speaker['foto']['title']; ?>">
								</div>
								<div>
									<strong><?php echo $speaker['titulo']; ?></strong>
									<p><?php echo $speaker['nombre']; ?></p>
									
									<img src="<?php echo get_stylesheet_directory_uri()."/imgs/flags/". $speaker['pais'].".svg" ?>" alt="flag" class="flag">
								</div>
							</div>

				<?php	} ?>

				</div>
				</div>
			</div>
		</div>
	</section>
	<?php 
	} } 
	?>

<!-- Programas  -->
<?php
	$evento_programa_descripcion = get_field('programa_descripcion');
	$evento_programa_descarga = get_field('programa_descarga');
	$evento_programa_detalle = get_field('programa_detalle');
?>
	<section class="space-sec">
		<div class="container">
			<div class="row flex-between-md ">
				<div>
					<h2>Programa</h2>
					<p class="m-0"><?php echo $evento_programa_descripcion; ?></p>
				</div>

				<?php if ($evento_programa_descarga != ''){ ?>
				<div class="download-program mt-2 mb-2">
					<a href="<?php echo $evento_programa_descarga; ?>" target="_blank">DESCARGAR PROGRAMA <img src="/wp-content/uploads/2021/01/down-arrow.svg" /></a>
				</div>
				<?php } ?>
			</div>
			
			<?php 

			if ($evento_programa_detalle){
			if(count($evento_programa_detalle) != 0){ 
				?>
				<div class="row">
					<div class="table-titles-program  mt-1 mb-1 bg-dark-gray">
						<div>ACTIVIDAD</div>
						<div>HORA</div>
						<div>SPEAKER</div>
					</div>
					<?php foreach($evento_programa_detalle as $bloque) { 						
							if($bloque['titulo_de_bloque'] != ''){ ?>
								<h2 class="mt-1 mb-1 color-red"><?php echo $bloque['titulo_de_bloque']; ?></h2>
							<?php } ?>

							<?php	foreach($bloque['actividad'] as $actividad) { ?> 
								<div class="table-titles-program table-content-program mt-1 mb-1">
									<div class="text-color"><?php echo $actividad['titulo']; ?></div>
									<div class="time-program text-color"><?php echo $actividad['hora']; ?></div>
									<div><strong class="text-color"><?php echo $actividad['speaker_nombre']; ?></strong> 
									  <p><?php echo $actividad['speaker_titulo']; ?></p>
									</div>
								</div>
							<?php } ?>
							<?php if($bloque['actividad_cierre']['titulo'] != '') { ?>
								<div class="table-titles-program range-questions mt-1 mb-1 bg-dark-gray c-random">
									<div class="time-program text-color"><?php echo $bloque['actividad_cierre']['hora']; ?></div>
									<div class="text-color"><?php echo $bloque['actividad_cierre']['titulo']; ?></div>
								</div>
							<?php } ?>		
					<?php } ?>

				</div>
			<?php }} ?>			
			<div class="height-100"></div>
		</div>
	</section>
	
</div>