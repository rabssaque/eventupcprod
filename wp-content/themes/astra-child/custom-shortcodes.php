<?php

/* Shortcode - Buscador  */
function buscador_eventos_function(){
	$be_result = "";
	ob_start();
	?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="buscador_eventos search-c" >
						<form role="search" action="<?php echo site_url('/eventos'); ?>" method="get" id="searchform">

							<p>Busca el evento de tu interés </p>
							<div>
								<input type="text" name="texto" placeholder="Encuentra eventos, charlas, workshops, congresos y mucho mas"/>
								<a href="javascript:void(0);" class="search-button">
									<div class="icon">
										<span class="clear">x</span>
									</div>
								</a>
							</div>
							
							<!-- <input type="hidden" name="post_type" value="products" /> -->
						</form>
					</div>
				</div>
			</div>
		</div>
		
	<?php
	$be_result .= ob_get_clean();

	return $be_result;
}
add_shortcode('buscador_eventos', 'buscador_eventos_function');





/* Shortcode - Slider  */
function home_slider_function(){

	$ids = array();

	if(is_tax()){
		$tax_obj = get_queried_object();

		
		$events_ids = get_field('slider_interno', $tax_obj);
		if($events_ids> 0){
			$ids = wp_list_pluck($events_ids, 'slider_evento');
		}
		
		
	} else {
		$events_ids = get_field('slider_principal','option');
		$ids = wp_list_pluck($events_ids, 'slider_evento');
	}

	$selected_prods = array();
	
	if(count($ids) > 0){
		$args = array(
			'include' => $ids
		);
		$selected_prods = wc_get_products( $args);
	} 
	
		
	$be_result = "";

	if(count($selected_prods) > 0){
		ob_start(); ?>
    <div class="relative">
		<div class="slider_home sliders-general" id="slider-event">

		<?php
		
		$mobile_image = get_stylesheet_directory_uri()."/imgs/slider_mobile-default.jpg";
		$desktop_image = get_stylesheet_directory_uri()."/imgs/slider_fondo_default.jpg";
		$array_slider_imgs = array();
			
		foreach ($selected_prods as $index => $prodf) {
			$fondo_slider = get_field('fondo_slider', $prodf->get_id());
			$fondo_slider_mobile = get_field('fondo_slider_mobile', $prodf->get_id());
			if($fondo_slider) {
				$product_fondo_slider = $fondo_slider["url"];
			} else{
				$product_fondo_slider = $desktop_image;
			}
			if($fondo_slider_mobile) {
				$product_fondo_slider_mobile = $fondo_slider_mobile["url"];
			} else{
				$product_fondo_slider_mobile = $mobile_image;
			}
			$array_slider_imgs[$index] = array(
				'mobile' => $product_fondo_slider_mobile,
				'desktop' => $product_fondo_slider,
			);
			// Fecha de evento (string)
			$product_fecha_timestamp = strtotime(get_field('fecha_de_evento', $prodf->get_id()));
			$product_fecha = date_i18n( "D, M j, h:i A", $product_fecha_timestamp );
			$product_fecha_fin_timestamp = strtotime(get_field('fecha_de_evento_final', $prodf->get_id()));
			if(!$product_fecha_fin_timestamp){
				$product_fecha_fin_timestamp = $product_fecha_timestamp;
			}

			// Tipo de evento. (array)
			$product_tipo_evento = get_field('tipo_de_evento', $prodf->get_id());
			if($product_tipo_evento["value"] == "online"){
				$current_date = current_time('timestamp');
				if( $product_fecha_timestamp <= $current_date  && $current_date  <= $product_fecha_fin_timestamp ){
					$product_tipo_evento["value"] = "en-vivo";
					$product_tipo_evento["label"] = "En vivo";
				} 
			} elseif($product_tipo_evento["value"] == "presencial"){
				$product_tipo_evento["label"] = get_field('presencial_campus', $prodf->get_id());
			}
			?>
			<div  class="event-slide event-slide_<?php echo $index; ?>" style="" >
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="tipo-evento tipo_<?php echo $product_tipo_evento["value"] ; ?> mb-2">
								<span >
									<?php if($product_tipo_evento["value"] == "en-vivo") { ?> 
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/video-camera.svg" alt="camera"> 
									<?php } ?>
									<?php echo $product_tipo_evento["label"] ; ?></span>
							</div>
							<div class="fecha mb-1">
								<span><?php echo $product_fecha; ?></span>
							</div>
							<div class="description-banner">
								<p><?php echo $prodf->get_name() ?></p>
							</div>
							<div class="c-register-item">
								<a href="<?php echo $prodf->get_permalink(); ?>">REGISTRARME</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		</div>
		<!-- Flechas - desktop -->
        <img class="d-none d-md-block prev arrow-left-home"
          src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/left.svg"
          alt="left">
        <img class="d-none d-md-block next arrow-right-home"
          src="<?php echo get_stylesheet_directory_uri(); ?>/imgs/right.svg"
		  alt="right">
		  <style>
				<?php foreach($array_slider_imgs as $ind => $imgs){ ?>
				.event-slide_<?php echo $ind; ?>{
					background-image: linear-gradient(0deg, rgba(1,4,23,0.48) 50%, rgba(1,4,23,0.48) 100%),  url( <?php echo $imgs['mobile']; ?>)
				}
				@media (min-width: 767px){
					.event-slide_<?php echo $ind; ?>{
						background-image: linear-gradient(0deg, rgba(1,4,23,0.48) 50%, rgba(1,4,23,0.48) 100%),  url( <?php echo $imgs['desktop']; ?>)
					}
				}
				<?php } ?>
			</style>
		</div>
		<?php
	
	} 

	$be_result .= ob_get_clean();

	return $be_result;
}
add_shortcode('home_slider', 'home_slider_function');








/* Shortcode - Productos home  */
function event_section_function($atts){
	$hs_result = '<div class="product_section">';
	
	// Seccion de Destacados 

	$variables = shortcode_atts(array(
			'taxonomia'=> '',
			'termino'=> '',
		),
		$atts);
	
	$arg_tax = array();
	
	$ids_featured = array();
	$query_featured = new WP_Query( array(
				'post_type' => 'product',
				'post_status' => 'publish',
        'posts_per_page' => 3,
        'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN', // or 'NOT IN' to exclude feature products
					),
					array(
						'taxonomy' => $variables['taxonomia'],
						'field' => 'slug',
						'terms' => $variables['termino']
					)

				)
    ));
	
	$featured_count = $query_featured->post_count;
	if($featured_count > 0){
		$container_type_size = 'container';
		$container_type = 'featured-products-type_'.$featured_count;

		
		if($featured_count == 1){
			$container_type_size = 'container-fluid';
			
		}

		ob_start();
		// Inicia la seccion de destacados 
		$hs_result .= '<div class="'.$container_type_size.' featured_products '.$container_type.'" >';
	}

	$index = 0;
	while ($query_featured->have_posts()) {
		$query_featured->the_post();
		$index ++;
		$ids_featured[] = get_the_ID();

		// Fecha de evento (string)
		$product_fecha_timestamp = strtotime(get_field('fecha_de_evento', get_the_ID()));
		$product_fecha = date_i18n( "D, M j, h:i A", $product_fecha_timestamp );
		// Tipo de evento. (array)
		$product_tipo_evento = get_field('tipo_de_evento', get_the_ID());
		if($product_tipo_evento["value"] == "presencial"){
			$product_tipo_evento["label"] = get_field('presencial_campus', get_the_ID());
		}

		$product_fondo_image = '';
		$product_container = false;
		if($featured_count == 1){
			$image_horizontal = get_field('destacado_fondo_horizontal_full', get_the_ID());
			if($image_horizontal) {
				$product_fondo_image = $image_horizontal["url"];
			} else{
				$product_fondo_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
				$product_fondo_image ? $product_fondo_image = $product_fondo_image[0] : $product_fondo_image = 'none';
			}
			
			$product_background = "background-image: url($product_fondo_image);";
			$product_container = true;
		}
		
		if($featured_count == 2 || ($featured_count == 3 && ($index == 1 || $index == 2)) ){
			$image_horizontal = get_field('destacado_fondo_cuadrado', get_the_ID());
			if($image_horizontal) {
				$product_fondo_image = $image_horizontal["url"];
			} else{
				$product_fondo_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
				$product_fondo_image ? $product_fondo_image = $product_fondo_image[0] : $product_fondo_image = 'none';
			}
			
			$product_background = "background-image: url($product_fondo_image);";
		}
		if($featured_count == 3 && $index == 0 ) {
			$image_horizontal = get_field('destacado_fondo_horizontal', get_the_ID());
			if($image_horizontal) {
				$product_fondo_image = $image_horizontal["url"];
			} else{
				$product_fondo_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
				$product_fondo_image ? $product_fondo_image = $product_fondo_image[0] : $product_fondo_image = 'none';
			}
			
			$product_background = "background-image: url($product_fondo_image);";
		}

			
		?>
			
			<div class="product_featured_item" style="<?php echo $product_background; ?>">
				<?php
					if($product_container){
						echo '<div class="container"><div class="row"><div class="col">';
					}
				?>
				<div class="description">
					<div class="tipo-evento  tipo_<?php echo $product_tipo_evento["value"] ; ?>">
						<span>
							<?php echo $product_tipo_evento["label"] ; ?>
						</span>
					</div>
					<div class="description_main-dtcado">
						<div class="fecha"><?php echo $product_fecha; ?></div>
						<h3><?php echo get_the_title() ?></h3>
						<div class="btn">
							<a href="<?php echo get_the_permalink(); ?>">Registrarme</a>
						</div>
					</div>
				</div>
				<?php
					if($product_container){
						echo '</div></div></div>';
					}
				?>
			</div>
				

		<?php
		
	}


	if($featured_count>0){
		$hs_result .= ob_get_clean();
		$hs_result .= '</div><!-- featured_products --> ';
	}

	// Seccion de grilla


	$prods_ids = array();

	$query_products= new WP_Query( array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'NOT IN', // or 'NOT IN' to exclude feature products
			),
			array(
				'taxonomy' => $variables['taxonomia'],
				'field' => 'slug',
				'terms' => $variables['termino']
			)

		)
	));


	while($query_products->have_posts()){
		$query_products->the_post();
		$prods_ids[] = get_the_ID();
	}

	if(count($prods_ids)> 0){

	    $ids = implode( ',', $prods_ids );

	    $hs_result .= '<div class="container product_list_grid">';
	    $hs_result .= '<div class="row"><div class="col">';
	    $hs_result .= do_shortcode ( "[products ids=$ids columns=4 ]" );
		$hs_result .= '</div></div>';		
		$hs_result .= '</div><!-- product_list_grid -->';
	}
	$hs_result .= '</div><!-- Product Section -->';

	return $hs_result;
}
add_shortcode('event_section', 'event_section_function');