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


?>
<div class="wrap" > 

<?php
  
  $myListTable = new My_Table_Subscriptions();
  $myListTable->prepare_items();
  ?>
  
  <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
  
  <form method="post">
    <input type="hidden" name="page" value="forms-processor-suscripciones" />
    <?php $myListTable->search_box('search', 'search_id'); ?>
  </form>
  <div>
    <button id="eupc-export_subscriptions">Exportar en CSV</button>
  </div>
  <?php
    $myListTable->display(); 

  
  
  
  ?>

</div>


