<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
});
</script>

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_16">
    <?php echo $pagination->create_links().nbs(1);?>
</div>
<!-- End Pagination -->

<?php echo clear_div();?>

<div class="grid_16">
    <?php if(sizeof($orders) == 0): ?>
        <div class="warning"><?php echo lang('order_no_order_history'); ?></div>
    <?php else: ?>
        <ul class="no-bullet order">
        <?php foreach($orders as $order): ?>
        <li>
            <table width="100%" id="order_list_<?php echo $order->id; ?>">
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_order_id')).': ';
                        $order_url = site_url('order/view/'.$order->id);
                        echo anchor(
                            $order_url,
                            '#'.$order->id
                        );
                    ?></td>
                    <td colspan="2" class="left"><?php
                        echo label(lang('order_status')).': ';
                        echo Customer_Order_Model::status($order->order_status);
                    ?></td>
                </tr>
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_order_date')).': ';
                        echo to_human_date_time($order->order_date);
                    ?></td>
                    <td width="40%"><?php 
                        echo label(lang('order_customer_name')).': ';
                        echo $order->first_name.', '.$order->last_name;
                    ?></td>
                    <td width="20%" rowspan="2" class="right"><?php 
                        echo button_link(
                            site_url('order/view/'.$order->id),
                            lang('view')
                        );
                    ?></td>
                </tr>
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_total_products')).': ';
                        echo sizeof($order->order_detail);
                    ?></td>
                    <td colspan="2" width="*"><?php 
                        echo label(lang('order_total')).': ';
                        echo to_currency($order->grand_total, 'MYR');
                    ?></td>
                </tr>
            </table>
        </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
