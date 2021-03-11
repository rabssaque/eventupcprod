<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 

echo do_shortcode('[home_slider]');

$tax_obj = get_queried_object();
?>



	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

    
    <section class="container c-red-left">
      <?php echo do_shortcode('[buscador_eventos]'); ?>
    </section>

		<section class="container c-red-left">
      <?php echo '<h2 class="fl-heading" ><span class="fl-heading-text">Descubre '.$tax_obj->name.'</span></h2>'; ?>
    </section>

    
    <?php
     
      echo do_shortcode('[event_section taxonomia="'.$tax_obj->taxonomy.'" termino="'.$tax_obj->slug.'"]');
      
    ?>



    <section class="container c-red-left">
      <div class="taxs-btn-more">
        <a href="<?php echo get_site_url(); ?>/eventos?<?php echo $tax_obj->taxonomy.'='.$tax_obj->slug ; ?>" class="fl-button">
          <span class="fl-button-text">Ver más</span>
          <!-- <i class="fl-button-icon fl-button-icon-after fas fa-chevron-right" aria-hidden="true"></i> -->
          <img src="<?php echo get_stylesheet_directory_uri()."/imgs/icon-right.svg"; ?>" alt="right">
        </a>
      </div>
    </section>

    <?php
 
    if($tax_obj->taxonomy === 'product_cat' && ( $tax_obj->slug === 'pregrado-upc' || $tax_obj->slug === 'epe-upc' || $tax_obj->slug === 'postgrado-upc' )){
      ?>
    <style>
      .menu-item:not(.menu-<?php echo $tax_obj->slug;?>){
        display: none !important;
      }
      .menu-<?php echo $tax_obj->slug;?>{
        display: list-item !important;
      }
    </style>


    <?php  }       ?>
    

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>