<?php
 
class Eupc_Filter_Widget extends WP_Widget {

  var $excludes_taxonomies = array('product_type', 'product_visibility', 'product_shipping_class');
 
  public function __construct() {
    parent::__construct(
      'eupc_filter_widget', // Base ID
      'Eventos UPC Filtros', // Name
      array( 'description' => __( 'Widget de filtros', 'eupc_filter_widget' ), ) // Args
    );
  }
 
    public function widget( $args, $instance ) {
      extract( $args );
      $title = apply_filters( 'widget_title', $instance['title'] );
      
 
      echo $before_widget;
      if ( ! empty( $title ) ) {
          echo $before_title . $title . $after_title;
      }
      ?>
      <div class="eupc-filters">
      

        <?php

          echo '<div class="eupc-filters_item search-filter search-c"><div>';
          echo '<input id="eupc-filter_text" data-slug="texto" type="text" placeholder="Buscar">';  
          echo '<a href="javascript:void(0);" class="search-button">
                  <div class="icon">
                    <span class="clear">x</span>
                  </div>
                </a>';
          echo '</div></div>';


          if(isset( $instance['selected_tax'])){
            // Tipo de evento
            if(isset($instance['selected_tax']['product_cat'])){
              $this->print_item(array(
                'name'=> 'Categoria',
                'query_var' => $instance['selected_tax']['product_cat']
              ));
            }
            // Area de interes
            if(isset($instance['selected_tax']['area_interes'])){
              $this->print_item(array(
                'name'=> 'Áreas de interés',
                'query_var' => $instance['selected_tax']['area_interes']
              ));
            }
            // Facultades
            if(isset($instance['selected_tax']['facultad'])){
              $this->print_item(array(
                'name'=> 'Facultades',
                'query_var' => $instance['selected_tax']['facultad']
              ));
            }
            // Carreras
            if(isset($instance['selected_tax']['carrera'])){
              $this->print_item(array(
                'name'=> 'Carreras',
                'query_var' => $instance['selected_tax']['carrera']
              ));
            }
            // Dirigido a
            if(isset($instance['selected_tax']['publico'])){
              $this->print_item(array(
                'name'=> 'Dirigido a',
                'query_var' => $instance['selected_tax']['publico']
              ));
            }
            // Formato
            if(isset($instance['selected_tax']['formato'])){
              $this->print_item(array(
                'name'=> 'Formato',
                'query_var' => $instance['selected_tax']['formato']
              ));
            }
            // Modalidad
            if(isset($instance['selected_tax']['modalidad'])){
              $this->print_item(array(
                'name'=> 'Modalidad',
                'query_var' => $instance['selected_tax']['modalidad']
              ));
            }
            // Precio
            if(isset($instance['selected_tax']['precio'])){
              $this->print_item(array(
                'name'=> 'Precio',
                'query_var' => $instance['selected_tax']['precio']
              ));
            }
            
            
          } 

          /* echo '<div class="eupc-filters_item">';
            echo '<select id="eupc-filter_precio" data-slug="precio">';  
            echo '<option value ="">Gratuito</option>';
            echo '<option value ="hoy">Pago</option>';
            echo '</select>';
          echo '</div>';*/

          echo '<div class="eupc-filters_item">';
            echo '<select id="eupc-filter_fecha" data-slug="fecha">';  
            echo '<option value ="">Fecha</option>';
            echo '<option value ="hoy">Hoy</option>';
            echo '<option value ="manana">Mañana</option>';
            echo '<option value ="semana">Esta semana</option>';
            echo '<option value ="mes">Próximo mes</option>';
            echo '</select>';
          echo '</div>';


        ?>
      
      </div>
  
      <?php 
      echo $after_widget;
    }
 
    public function form( $instance ) {
      $taxonomies_objects = get_object_taxonomies( 'product', 'objects' );
      $taxs_args = array();
      
      
      foreach($taxonomies_objects as $taxonomy){
        if(!in_array($taxonomy->name, $this->excludes_taxonomies)){
          $prepare_tax = array(
            'name' =>  $taxonomy->name,
            'value' => $taxonomy->name,
            'label' => $taxonomy->label,
            'checked' => ''
          );
          if(isset($instance['selected_tax'])){
            if(isset($instance['selected_tax'][$taxonomy->name])){
              $prepare_tax['checked']= '1';
            }
          }
          $taxs_args[$taxonomy->name] = $prepare_tax;
        }
      }
      
      $instance['selected_tax'] = $taxs_args;
      

      $defaults = array(
        'title' => __( 'Búsqueda avanzada', 'eupc_filter_widget' ),
        'selected_tax' => $taxs_args
      );

      $instance = wp_parse_args((array) $instance, $defaults);
      
      $title = $instance[ 'title' ];
      $tax_list = $instance['selected_tax'];
    
      ?>
      <p>
          <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
          
      </p>
      <h4>Filtrar por taxonomias</h4>
      <div>    
      <?php
        foreach($tax_list as $tax){ ?>
            <div class='checkbox'>
            <label>
                <input type="checkbox"
                       name="<?php echo $this->get_field_name( 'selected_tax' ), '[', esc_attr( $tax['name'] ), ']'; ?>"
                      class="form-control"
                         id="<?php echo $this->get_field_id($tax['name']); ?>"
                      value="<?php echo $tax['value']; ?>"
                   <?php checked('1', $tax['checked']); ?>/>
                   <?php echo $tax['label']; ?>
            </label>
        </div>
        <?php
          
        }
      ?>
      </div>
      <?php
    }
 
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['selected_tax'] = $new_instance['selected_tax'];

    return $instance;
  }


  private function print_item($tax){

    $tax_terms = get_terms(array(
      'taxonomy' => $tax['query_var']
    ));

    echo '<div class="eupc-filters_item">';
      echo '<select id="eupc-filter_'.$tax['query_var'].'" data-slug="'.$tax['query_var'].'">';  
      echo '<option value ="">'.$tax['name'].'</option>';
      foreach($tax_terms as $term){
        echo '<option value='.$term->slug.'>'.$term->name.'</option>';
      }
      echo '</select>';
    echo '</div>';
  }
}
 
// Register Foo_Widget widget
add_action( 'widgets_init', 'register_eupc_filter' );
     
function register_eupc_filter() { 
  register_widget( 'Eupc_Filter_Widget' );
}

// Register scripts
function eupc_filter_scripts() {
	wp_enqueue_script('eupc_filter_script', get_stylesheet_directory_uri() . '/eupc-filter/js/eupc-filter-widget.js', array('jquery'),'1.1', true);
  wp_localize_script( 'eupc_filter_script', 'ajax_var_filter', array(
    'url'    => admin_url( 'admin-ajax.php' ),
    'nonce'  => wp_create_nonce( 'eupc-filers-nonce' ),
    'action' => 'filter_events'
) );
} 
add_action( 'wp_enqueue_scripts', 'eupc_filter_scripts', 15 );

function filter_eventes_cb() {
  // Check for nonce security
  $nonce = sanitize_text_field( $_POST['nonce'] );

  if ( ! wp_verify_nonce( $nonce, 'eupc-filers-nonce' ) ) {
      die ('hola nonce');
  }

  $paged = 1;
  if(isset($_POST['page'])){
    $paged = sanitize_text_field( $_POST['page']);
  }
  

  if(isset($_POST['product_cat'])){
    $filter['product_cat'] = sanitize_text_field( $_POST['product_cat'] );
  }
  if(isset($_POST['area_interes'])){
    $filter['area_interes'] = sanitize_text_field( $_POST['area_interes'] );
  }
  if(isset($_POST['facultad'])){
    $filter['facultad'] = sanitize_text_field( $_POST['facultad'] );
  }
  if(isset($_POST['carrera'])){
    $filter['carrera'] = sanitize_text_field( $_POST['carrera'] );
  }
  if(isset($_POST['publico'])){
    $filter['publico'] = sanitize_text_field( $_POST['publico'] );
  }
  if(isset($_POST['formato'])){
    $filter['formato'] = sanitize_text_field( $_POST['formato'] );
  }
  if(isset($_POST['modalidad'])){
    $filter['modalidad'] = sanitize_text_field( $_POST['modalidad'] );
  }
  if(isset($_POST['texto'])){
    $filter_text = sanitize_text_field( $_POST['texto'] );
  }

  $meta_query = array();
  if(isset($_POST['fecha'])){
    $search_fecha = sanitize_text_field( $_POST['fecha'] );
    $date_now = date('Y-m-d', current_time('timestamp'));
    
    $date_tomorrow = date('Y-m-d', strtotime( "+1 days",  current_time('timestamp')));
    $date_week = date('Y-m-d', strtotime( "+1 week",  current_time('timestamp')));
    $date_nex_month_ini = date('Y-m-d', strtotime( "+1 month",  current_time('timestamp')));
    $date_nex_month_fin = date('Y-m-d', strtotime( "+2 month",  current_time('timestamp')));

    switch($search_fecha){
      case 'hoy':
        $meta_query = array(
          'relation' 			=> 'OR',
          array(
            'key'			=> 'fecha_de_evento',
            'compare'		=> '==',
            'value'			=> $date_now,
            'type'			=> 'DATE'
          ),
          array(
            'relation' => 'AND',
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '<',
              'value'			=> $date_now,
              'type'			=> 'DATE'
            ),
            array(
              'key'			=> 'fecha_de_evento_final',
              'compare'		=> '>=',
              'value'			=> $date_now,
              'type'			=> 'DATE'
            )
          )
        );
        break;
      case 'manana':
        $meta_query = array(
          'relation' 			=> 'OR',
          array(
            'key'			=> 'fecha_de_evento',
            'compare'		=> '==',
            'value'			=> $date_tomorrow,
            'type'			=> 'DATE'
          ),
          array(
            'relation' => 'AND',
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '<',
              'value'			=> $date_tomorrow,
              'type'			=> 'DATE'
            ),
            array(
              'key'			=> 'fecha_de_evento_final',
              'compare'		=> '>=',
              'value'			=> $date_tomorrow,
              'type'			=> 'DATE'
            )
          )
        );
        break;
      case 'semana':
        $meta_query = array(
          'relation' 			=> 'OR',
          array(
            'relation' => 'AND',
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '>=',
              'value'			=> $date_now,
              'type'			=> 'DATE'
            ),
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '<=',
              'value'			=> $date_week,
              'type'			=> 'DATE'
            )
          )/*,
          array(
            'relation' => 'AND',
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '<',
              'value'			=> $date_now,
              'type'			=> 'DATE'
            ),
            array(
              'key'			=> 'fecha_de_evento_final',
              'compare'		=> '>=',
              'value'			=> $date_now,
              'type'			=> 'DATE'
            )
          )*/
        );
        break;
      case 'mes':
        $meta_query = array(
          'relation' 			=> 'OR',
          array(
            'relation' => 'AND',
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '>=',
              'value'			=> $date_nex_month_ini,
              'type'			=> 'DATE'
            ),
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '<=',
              'value'			=> $date_nex_month_fin,
              'type'			=> 'DATE'
            )
          )/*,
          array(
            'relation' => 'AND',
            array(
              'key'			=> 'fecha_de_evento',
              'compare'		=> '<',
              'value'			=> $date_nex_month_ini,
              'type'			=> 'DATE'
            ),
            array(
              'key'			=> 'fecha_de_evento_final',
              'compare'		=> '>=',
              'value'			=> $date_nex_month_ini,
              'type'			=> 'DATE'
            )
          )*/
        );
        break;
      default:
    }
  }

  $tax_query = array();
  foreach($filter as $tax => $val){
    $tax_query[] = array(
      'taxonomy' => $tax,
      'field' => 'slug',
      'terms' => $val
    );
  }

  $search_text = isset($filter_text) ? $filter_text : '';

  $args = array(
    'post_type' => 'product',
    's' => $search_text,
    'meta_query' => $meta_query,
    'tax_query' => $tax_query,
    'posts_per_page' => 12,
    'paged' => $paged
  );
  $query = new WP_Query( $args );

  if ( $query->have_posts() ) {
    echo '<p class="woocommerce-result-count">Resultados: '. $query->found_posts .' evento(s)</p>';
    echo '<ul class="products columns-3">';
    while ($query->have_posts()) {
      $query->the_post();
      wc_get_template_part( 'content', 'product' );
    }
    echo '</ul>';

    $total_pages = $query->max_num_pages;

    if ($total_pages > 1){

        $current_page = $paged;

        echo '<nav class="woocommerce-pagination">';
        echo 'Página ';
        $pages = paginate_links(array(
            'base' =>  '%_%',
            'format' => '/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => __('« prev'),
            'next_text'    => __('next »'),
            'type'  => 'array',
        ));
        if( is_array( $pages ) ) {
         
          echo '<ul class="page-numbers">';
          foreach ( $pages as $page ) {
            echo "<li>$page</li>";
          }
          echo '</ul>';
        }
        /*<ul class="page-numbers">
        <li><span aria-current="page" class="page-numbers current">1</span></li>
        <li><a class="page-numbers" href="https://eventos.upc.edu.pe/eventos/page/2/">2</a></li>
        <li><a class="next page-numbers" href="https://eventos.upc.edu.pe/eventos/page/2/">→</a></li>
      </ul>*/
        echo '</nav>';
        
    }
  }

  

  

  wp_die();
}
add_action( 'wp_ajax_nopriv_filter_events', 'filter_eventes_cb' );
add_action( 'wp_ajax_filter_events', 'filter_eventes_cb' );



/* Export events  */
function export_events_function($atts){
	$hs_result = '<div class="product_section">';
	
	 $filter = array();
	// Seccion de grilla
	$prods_ids = array();

	if(isset($_POST['product_cat'])){
    $filter['product_cat'] = sanitize_text_field( $_POST['product_cat'] );
  }
  if(isset($_POST['area_interes'])){
    $filter['area_interes'] = sanitize_text_field( $_POST['area_interes'] );
  }
  if(isset($_POST['facultad'])){
    $filter['facultad'] = sanitize_text_field( $_POST['facultad'] );
  }
  if(isset($_POST['carrera'])){
    $filter['carrera'] = sanitize_text_field( $_POST['carrera'] );
  }
  if(isset($_POST['publico'])){
    $filter['publico'] = sanitize_text_field( $_POST['publico'] );
  }
  if(isset($_POST['formato'])){
    $filter['formato'] = sanitize_text_field( $_POST['formato'] );
  }
  if(isset($_POST['modalidad'])){
    $filter['modalidad'] = sanitize_text_field( $_POST['modalidad'] );
  }

	$tax_query = array();
  foreach($filter as $tax => $val){
    $tax_query[] = array(
      'taxonomy' => $tax,
      'field' => 'slug',
      'terms' => $val
    );
  }

  $args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'tax_query' => $tax_query,
    'posts_per_page' => 4,
  );
  $query_events = new WP_Query( $args );


	while($query_events->have_posts()){
		$query_events->the_post();
    $prods_ids[] = get_the_ID();
	}

	if(count($prods_ids)> 0){
	    $ids = implode( ',', $prods_ids );
      $hs_result .= '<div class="container product_list_grid">';
      $hs_result .= '<div class="row"><div class="col">';
        $hs_result .= do_shortcode ( "[products ids=$ids columns=4 ]" );
      $hs_result .= '</div></div>';   
      $hs_result .= '</div><!-- product_list_grid -->';

      $hs_result .= '<div class="container c-red-left">
      <div class="taxs-btn-more">
        <a href="https://eventos.upc.edu.pe/eventos" class="fl-button">
          <span class="fl-button-text">Ver más</span>
          <i class="fl-button-icon fl-button-icon-after fas fa-chevron-right" aria-hidden="true"></i>
        </a>
      </div>
    </div>';
	}
	$hs_result .= '</div><!-- Product Section -->';
	ob_start();

	$hs_result .= ob_get_clean();
  echo $hs_result;
  wp_die();
}

add_action( 'wp_ajax_nopriv_get_events', 'export_events_function' );
add_action( 'wp_ajax_get_events', 'export_events_function' );

add_filter('allowed_http_origins', 'add_allowed_origins');

function add_allowed_origins($origins) {
    $origins[] = 'https://eventos.upc.edu.pe';
    $origins[] = 'http://eventos.localhost';
    return $origins;
}

