<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );


/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'fonts-css', get_stylesheet_directory_uri() . '/css/fuentes.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'style-nunito', 'https://fonts.googleapis.com/css2?family=Nunito&display=swap'  );
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/css/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	

}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


function wpb_adding_scripts() {
	// wp_enqueue_script( 'script-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js');
	wp_register_script('my_amazing_script2',  'https://pregrado.upc.edu.pe/static/js/slick-carousel@1.8.1/slick/slick.min.js');
	wp_register_script('my_amazing_script', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'),'1.1', true);

	wp_enqueue_script('script-modal');
	wp_enqueue_script('my_amazing_script2');
	wp_enqueue_script('my_amazing_script');

	
 } 
 add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts', 15 );
  
// INCLUDES 

include_once( get_stylesheet_directory() .'/custom-shortcodes.php');
include_once( get_stylesheet_directory() .'/footer_before.php');

include_once( get_stylesheet_directory() .'/eupc-filter/eupc-filter-widget.php' );

include_once( get_stylesheet_directory() .'/eupc/eupc.php' );



// Quitar breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

// Taxonomi main slider
function taxonomies_header_slider(){
	if(is_tax() && !is_shop()){
		echo do_shortcode('[home_slider]');
	}
}
add_action('woocommerce_before_main_content', 'taxonomies_header_slider', 5);

add_filter( 'template_include', 'taxonomies_template', 99 );
function taxonomies_template( $template ) {
    if ( is_tax() && !is_shop() ) {
      $new_template = locate_template( array( 'product-taxonomy.php' ) );
			if ( '' != $new_template ) {
					return $new_template ;
			}
    }
    return $template;
}


function register_additional_menu() {
  
	register_nav_menu( 'third-menu' ,
	__( 'Third Navigation Menu Footer' ));

}
add_action( 'init', 'register_additional_menu' );

add_action( 'wp_footer', 'add_third_nav_footer' ); 
	
function add_third_nav_footer() {
	echo '<footer>
			<!-- <div class="container">
					<div class="row flex-md-between">
						<div class="col-4 col-md-2">
							<img src="https://eventos.upc.edu.pe/wp-content/uploads/2021/02/wasc.svg" alt="img" />
						</div>
						<div class="col-5 col-md-2">
							<img src="https://eventos.upc.edu.pe/wp-content/uploads/2021/02/exigete.svg" alt="img" />
						</div>
					</div>
				    <hr class="mt-1">	
			</div> -->
			<div class="container">
				<div class="row"> 
					<div class="col-md-12 mt-1 mb-1">';
				wp_nav_menu( array( 
					'theme_location' => 'third-menu', 
					'container_class' => 'nav-menu-footer' ) );
					
	echo '			</div>
				</div>
			</div>
		</footer>';

	
}


add_action('wp_head', function(){ 
	?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NFTQJJL');</script>
	<!-- End Google Tag Manager -->

	<?php 
 });
add_action( 'wp_footer', function(){ 
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NFTQJJL"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?php 
 });

