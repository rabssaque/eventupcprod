<?php

require_once(plugin_dir_path( __FILE__ ) .'class-forms-processor-list-table.php');
		
		class My_Table_Subscriptions extends Forms_Processor_List_Table { 
     
    public static function get_subscriptions( $per_page = 20, $page_number = 1 ) {
      $subscripciones = array();
  
      global $wpdb;
      
      $sql = "SELECT * FROM {$wpdb->prefix}eventos_suscripciones";
      $res_subs = $wpdb->get_results( $sql );
      foreach($res_subs as $subs){
        $subscripciones[] = array(
          'id'=> $subs->id,
          'email'=> $subs->email,
          'fecha_registro'=> $subs->fecha_registro
        );
      } 
      return $subscripciones;
    }

    function get_columns () { 
      $columns = array (
        'id' => 'ID',
        'email'=> 'Email',
        'fecha_registro'=> 'Registrado'
      );
      return $columns; 
    }

    function prepare_items () {
 
      $data = self::get_subscriptions();
      $columns = $this -> get_columns (); 
      $hidden = array(); 
      $sortable = $this->get_sortable_columns(); 
      $this->_column_headers = array( $columns ,$hidden , $sortable ); 
      usort( $data, array( &$this, 'usort_reorder' ) );
      
      $per_page = 20;
      $current_page = $this->get_pagenum();
      $total_items = count( $data );
      
      // Sólo necesario porque usamos nuestros datos de ejemplo
      $found_data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );
      $this->set_pagination_args( array(
        'total_items' => $total_items,  // DEBEMOS calcular el número total de elementos
        'per_page'    => $per_page  // DEBEMOS determinar el número de elementos en cada página
      ) );
      $this->items = $found_data;
    }



    function column_default( $item, $column_name ) {
      switch( $column_name ) { 
        case 'id':
        case 'email':
        case 'fecha_registro':
          return $item[ $column_name ];
        default:
          return print_r( $item, true ) ; // Mostramos todo el arreglo para resolver problemas
      }
    }
    function get_sortable_columns() {
      $sortable_columns = array(
        'id' => array( 'id', true ),
        'email'=> array('email', true ),
        'fecha_registro'=> array('fecha_registro', true )
      );
      return $sortable_columns;
    }
    function usort_reorder( $a, $b ) {
      // Orden por defecto
      $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'fecha_registro';
      // Si no hay orden, por defecto descendente
      $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'desc';
      // Determina el orden de ordenamiento
      $result = strcmp( $a[$orderby], $b[$orderby] );
      // Envía la dirección de ordenamiento final a usort
      return ( $order === 'desc' ) ? $result : -$result;
    } 

  }

    