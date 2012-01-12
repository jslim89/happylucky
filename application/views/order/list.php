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
        <span class="warning"><?php echo lang('order_no_order_history'); ?></span>
    <?php // else: ?>
        <ul class="no-bullet order">
        <li>
            <table id="order_list_<?php echo 0; ?>" class="order-list" width="100%">
                <tr>
                    <td width="25%"><?php 
                        echo label(lang('order_order_id')).': ';
                        $order_url = site_url('order/view/'.'0');
                        echo anchor(
                            $order_url,
                            0
                        );
                    ?></td>
                    <td width="*" colspan="2" class="right"><?php 
                        echo label(lang('order_status')).': ';
                        echo 'Pending';
                    ?></td>
                </tr>
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_order_date')).': ';
                        echo to_human_date_time(time());
                    ?></td>
                    <td width="40%"><?php 
                        echo label(lang('order_customer_name')).': ';
                        echo 'Foo Bar';
                    ?></td>
                    <td width="20%" rowspan="2" class="right"><?php 
                        echo button_link(
                            site_url('order/view/1'),
                            lang('view')
                        );
                    ?></td>
                </tr>
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_total_products')).': ';
                        echo 5;
                    ?></td>
                    <td width="40%"><?php 
                        echo label(lang('order_total')).': ';
                        echo to_currency(15880, 'MYR');
                    ?></td>
                </tr>
            </table>
        </li>
        <li>
            <table id="order_list_<?php echo 0; ?>" class="order-list" width="100%">
                <tr>
                    <td width="25%"><?php 
                        echo label(lang('order_order_id')).': ';
                        $order_url = site_url('order/view/'.'0');
                        echo anchor(
                            $order_url,
                            0
                        );
                    ?></td>
                    <td width="*" colspan="2" class="right"><?php 
                        echo label(lang('order_status')).': ';
                        echo 'Pending';
                    ?></td>
                </tr>
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_order_date')).': ';
                        echo to_human_date_time(time());
                    ?></td>
                    <td width="40%"><?php 
                        echo label(lang('order_customer_name')).': ';
                        echo 'Foo Bar';
                    ?></td>
                    <td width="20%" rowspan="2" class="right"><?php 
                        echo button_link(
                            site_url('order/view/1'),
                            lang('view')
                        );
                    ?></td>
                </tr>
                <tr>
                    <td width="40%"><?php 
                        echo label(lang('order_total_products')).': ';
                        echo 5;
                    ?></td>
                    <td width="40%"><?php 
                        echo label(lang('order_total')).': ';
                        echo to_currency(15880, 'MYR');
                    ?></td>
                </tr>
            </table>
        </li>
        <?php foreach($orders as $order): ?>
        <li>
            <table id="order_list_<?php echo $order->id; ?>">
                <tr>
                    <td width="25%"><?php 
                        echo label(lang('order_id')).': ';
                        $order_url = site_url('order/view/'.$order->id);
                        echo anchor(
                            $order_url,
                            img(array(
                                'src'    => $order->primary_image_url,
                                'alt'    => $order->order_name,
                                'width'  => 80,
                                'height' => 80,
                            ))
                        );
                    ?></td>
                    <td width="*"><?php
                    echo anchor($order_url, $order->order_code.' - '.$order->order_name);
                    echo br(1);
                    echo '<span class="expander">'.$order->order_desc.'</span>';
                    ?></td>
                    <td width="10%"><?php
                        echo 'RM'.$order->standard_price;
                    ?></td>
                </tr>
            </table>
        </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
