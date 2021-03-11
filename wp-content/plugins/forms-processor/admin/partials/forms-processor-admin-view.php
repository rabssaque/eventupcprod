<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/admin/partials
 */


  $action = isset($_GET['action']) ? $_GET['action'] : '';
  $idevent = isset($_GET['ideven']) ? $_GET['ideven'] : '';
  // $idevent = '1';
?>
<div class="wrap" > 

<?php
  if($action == ''){
    $myListTable = new My_Table_Events();
    $myListTable->prepare_items();
    ?>
    
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form method="post">
      <input type="hidden" name="page" value="my_list_test" />
      <?php $myListTable->search_box('search', 'search_id'); ?>
    </form> 
    <?php
      $myListTable->display(); 

  } 
  
  
  
  elseif($action == 'view' && $idevent != ''){
    $myListTable = new My_Table_Registers();
    $myListTable->__set('idevent', 1);
    $myListTable->prepare_items();
    ?>
    
    <h2><?php echo esc_html( get_the_title( $idevent ) ); ?> - Registros </h2>
    <form method="post">
      <input type="hidden" name="page" value="my_list_test" />
      <?php $myListTable->search_box('search', 'search_id'); ?>
    </form> 
    <div>
    <button id="eupc-export_registers" data-event_id="<?php echo $idevent; ?>">Exportar en CSV</button>
  </div>
    <?php
      $myListTable->display();
  }
  ?>

</div>


