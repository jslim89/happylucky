<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->lang->load('product');
?>
<div class="table-header">
    <?php echo lang('dashboard_stock_to_be_reload');?>
</div>
<?php
if(count($stocks) < 1) { // if
    echo "<div class='nothing-msg'>".lang('dashboard_no_stock_to_be_reload')."</div>";
} // End if 
else { // else
?>
<table id="pending_order_list" class="listing">
    <tr>
        <th width="15%"><?php echo lang('product_code');?></th>
        <th width="30%"><?php echo lang('product_name');?></th>
        <th width="10%"><?php echo lang('product_quantity_left');?></th>
        <th width="45%"><?php echo lang('product_suppliers_available');?></th>
    </tr>
    <?php foreach($stocks as $stock):?>
    <tr>
        <td><a href="admin/product/edit/<?php echo $stock->product_id;?>">
            <?php echo $stock->product_code;?>
        </a></td>
        <td><?php echo $stock->product_name;?></td>
        <td><?php echo $stock->quantity_available;?></td>
        <td>
            <?php echo $stock->suppliers_available;?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
} // End else
?>
