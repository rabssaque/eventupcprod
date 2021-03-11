<?php

require_once(plugin_dir_path( __FILE__ ) .'class-forms-processor-list-table.php');
		
		class My_Table_Events extends Forms_Processor_List_Table { 
     
    
    public static function get_events( $per_page = 20, $page_number = 1 ) {
      $products = array();
  
      $prod_objects = wc_get_products( array(
            'limit' => -1
            // 'category' => array( $variables['categoria'] )
        ));
      foreach ($prod_objects as $index => $prod) {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}eventos_registros WHERE evento_id = {$prod->get_id()}";

        $products[] = array(
          'id' => $prod->get_id(),
          'nombre' => $prod->get_name(),
          'registros' => $wpdb->get_var( $sql )
        );
      }
      return $products;
    }

    function get_columns () { 
      $columns = array (
        'id' => 'ID', 
        'nombre' => 'Evento', 
        'registros' => '# Registrados' ); 
      return $columns; 
    }

    function prepare_items () { 
      $data = self::get_events();
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
        case 'nombre':
        case 'registros':
          return $item[ $column_name ];
        default:
          return print_r( $item, true ) ; // Mostramos todo el arreglo para resolver problemas
      }
    }
    function get_sortable_columns() {
      $sortable_columns = array(
        'id' => array( 'id',false ),
        'nombre' => array( 'nombre', false ),
        'registros'  => array( 'registros', false )
      );
      return $sortable_columns;
    }
    function usort_reorder( $a, $b ) {
      // Si no se especifica columna, por defecto el título
      $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'id';
      // Si no hay orden, por defecto asendente
      $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
      // Determina el orden de ordenamiento
      $result = strcmp( $a[$orderby], $b[$orderby] );
      // Envía la dirección de ordenamiento final a usort
      return ( $order === 'asc' ) ? $result : -$result;
    } 

    function column_nombre( $item ) {
      $actions = array(
                'view'      => sprintf('<a href="?page=%s&action=%s&ideven=%s">Ver registros</a>',$_REQUEST['page'],'view',$item['id'] ),
            );
    
      return sprintf('%1$s %2$s', $item['nombre'], $this->row_actions( $actions ) );
    }
    function column_registros( $item ) {
      $actions = array(
                'view'      => sprintf('<a href="?page=%s&action=%s&ideven=%s">Ver registros</a>',$_REQUEST['page'],'view',$item['id'] ),
            );
    
      return sprintf('%1$s %2$s', $item['registros'], $this->row_actions( $actions ) );
    }

  }

    