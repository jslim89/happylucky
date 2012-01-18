<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->lang->load('order');
?>
<div class="box">
    <div class="box-heading"><?php
        echo lang('dashboard_pending_order');
    ?></div>
    <div class="box-content">
        <?php if(count($pending_orders) < 1): ?>
            <div class='success'><?php 
                echo lang('dashboard_no_pending_order');
            ?></div>
        <?php else: ?>
            <table id="pending_order_list" class="listing" width="100%">
                <tr class="left">
                    <th width="15%"><?php echo lang('order_order_id');?></th>
                    <th width="25%"><?php echo lang('order_customer_name');?></th>
                    <th width="15%"><?php echo lang('order_contact_no');?></th>
                    <th width="30%"><?php echo lang('order_order_date');?></th>
                    <th width="15%"><?php echo lang('order_total_amount');?></th>
                </tr>
                <?php foreach($pending_orders as $pending_order):?>
                <tr>
                    <td><?php
                        echo anchor(
                            site_url('admin/order/view/'.$pending_order->id),
                            $pending_order->id
                        );
                    ?></td>
                    <td><?php
                        if($pending_order->is_member_order()) {
                            $name = anchor(
                                site_url('admin/customer/edit/'.$pending_order->customer_id),
                                $pending_order->first_name.", ".$pending_order->last_name
                            );
                        }
                        else {
                            $name = $pending_order->first_name.", ".$pending_order->last_name;
                        }
                        echo $name;
                    ?></td>
                    <td><?php echo $pending_order->shipping_contact_no;?></td>
                    <td><?php echo to_human_date_time($pending_order->order_date);?></td>
                    <td><?php echo to_currency($pending_order->grand_total);?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
