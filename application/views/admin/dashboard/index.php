<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
foreach($widgets as $widget):
?>
    <div class="grid_16">
        <?php $this->load->view('admin/dashboard/widget/'.$widget);?>
    </div>
<?php 
    echo clear_div();
    endforeach;
?>
