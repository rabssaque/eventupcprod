<?php

require_once(plugin_dir_path( __FILE__ ) .'class-forms-processor-list-table.php');
		
		class My_Table_Registers extends Forms_Processor_List_Table { 
     
    public static function get_registers( $idevent, $per_page = 20, $page_number = 1 ) {
      $registros = array();
  
      global $wpdb;
      if($idevent != ''){
        $sql = "SELECT * FROM {$wpdb->prefix}eventos_registros WHERE evento_id = {$idevent}";
        $regresults = $wpdb->get_results( $sql );
        foreach($regresults as $reg){
          $registros[] = array(
            'nombre'=> $reg->nombre,
            'ape_paterno'=> $reg->ape_paterno,
            'ape_materno'=> $reg->ape_materno,
            'email'=> $reg->email,
            'celular'=> $reg->celular,
            'doc_tipo'=> $reg->doc_tipo,
            'doc_numero'=> $reg->doc_numero,
            'genero'=> $reg->genero,
            'fecha_registro'=> $reg->fecha_registro,
            'zoom_metting_id' => $reg->zoom_meeting_id,
            'zoom_register_id' => $reg->zoom_register_id
          );
        } 
      }


      return $registros;
    }

    function get_columns () { 
      $columns = array (
        'nombre' => 'Nombre',  
        'ape_paterno'=> 'Ape. Paterno',
        'ape_materno'=> 'Ape. Materno',
        'email'=> 'Email',
        'celular'=> 'Celular',
        'doc_tipo'=> 'Tipo Doc.',
        'doc_numero'=> 'Num. Doc.',
        'genero'=> 'Genero',
        'fecha_registro'=> 'Fec. Registro',
        'zoom_metting_id' => 'Zoom Meeting',
        'zoom_register_id' => 'Zoom user'
      );
      return $columns; 
    }

    function prepare_items () {
      $idevent = isset($_GET['ideven']) && ctype_digit($_GET['ideven'])
      ? (int)$_GET['ideven'] 
      : 0;
      $data = self::get_registers($idevent);
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
        case 'nombre':
        case 'ape_paterno':
        case 'ape_materno':
        case 'email':
        case 'celular':
        case 'doc_tipo':
        case 'doc_numero':
        case 'genero':
        case 'fecha_registro':
        case 'zoom_metting_id':
        case 'zoom_register_id':
          return $item[ $column_name ];
        default:
          return print_r( $item, true ) ; // Mostramos todo el arreglo para resolver problemas
      }
    }
    function get_sortable_columns() {
      $sortable_columns = array(
        'nombre' => array( 'nombre', false ),
        'ape_paterno'=> array('ape_paterno', false ),
        'ape_materno'=> array('ape_materno', false ),
        'email'=> array('email', false ),
        'celular'=> array('celular', false ),
        'doc_tipo'=> array('doc_tipo', false ),
        'doc_numero'=> array('doc_numero', false ),
        'genero'=> array('genero', false ),
        'fecha_registro'=> array('fecha_registro', false ),
        'zoom_metting_id'=> array('zoom_metting_id', false ),
        'zoom_register_id'=> array('zoom_register_id', false )
      );
      return $sortable_columns;
    }
    function usort_reorder( $a, $b ) {
      // Si no se especifica columna, por defecto el título
      $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'fecha_registro';
      // Si no hay orden, por defecto asendente
      $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
      // Determina el orden de ordenamiento
      $result = strcmp( $a[$orderby], $b[$orderby] );
      // Envía la dirección de ordenamiento final a usort
      return ( $order === 'asc' ) ? $result : -$result;
    } 

  

  }

    