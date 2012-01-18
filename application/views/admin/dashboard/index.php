<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="grid_16">
    <?php
        foreach($widgets as $widget):
            $this->load->view('admin/dashboard/widget/'.$widget);
        endforeach;
    ?>
</div>
<?php echo clear_div();?>
