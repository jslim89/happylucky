<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="grid_16">
<?php foreach($widgets as $widget): ?>
<div class="box">
</div>
        <?php $this->load->view('admin/dashboard/widget/'.$widget);?>
<?php 
    echo clear_div();
    endforeach;
?>
</div>
