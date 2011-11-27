<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->lang->load('order');
?>
<div class="table-header">
    <?php echo lang('dashboard_pending_order');?>
</div>
<?php
if(count($pending_orders) < 1) { // if
    echo "<div class='nothing-msg'>".lang('dashboard_no_pending_order')."</div>";
} // End if 
else { // else
?>
<table id="pending_order_list" class="listing">
    <tr>
        <th width="15%"><?php echo lang('order_order_id');?></th>
        <th width="30%"><?php echo lang('order_customer_name');?></th>
        <th width="15%"><?php echo lang('order_contact_no');?></th>
        <th width="25%"><?php echo lang('order_order_date');?></th>
        <th width="15%"><?php echo lang('order_total_amount');?></th>
    </tr>
    <?php foreach($pending_orders as $pending_order):?>
    <tr>
        <td><a href="admin/order/view/<?php echo $pending_order->order_id;?>">
            <?php echo $pending_order->order_id;?>
        </a></td>
        <td><?php echo $pending_order->order_date;?></td>
        <td><?php echo $pending_order->first_name.", ".$pending_order->last_name;?></td>
        <td><?php echo $pending_order->shipping_contact_no;?></td>
        <td><?php echo $pending_order->grand_total;?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
} // End else
?>
</table>
