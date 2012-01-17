<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'order');
    });
    $('#order_form').validationEngine('attach');
});
</script>

<div id="order-content">
    <form id="order_form" method="POST">
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td colspan="2" class="left"><?php
                        echo lang('order_detail');
                    ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" width="50%"><?php
                        echo label(lang('order_order_id')).': ';
                        echo $order->id;
                        echo br(1);
                        echo label(lang('order_status')).': ';
                        echo Customer_Order_Model::status($order->order_status);
                    ?></td>
                    <td class="left"><?php
                        echo label(lang('order_order_date')).': ';
                        echo to_human_date_time($order->order_date);
                    ?></td>
                </tr>
            </tbody>
        </table>
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td colspan="2" class="left"><?php
                        echo lang('order_shipping_and_billing_address');
                    ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><?php
                        echo nl2br($order->get_full_address());
                    ?></td>
                </tr>
            </tbody>
        </table>
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td class="left"><?php
                        echo lang('product_code');
                    ?></td>
                    <td class="left"><?php
                        echo lang('product_name');
                    ?></td>
                    <td class="right"><?php
                        echo lang('product_quantity');
                    ?></td>
                    <td class="right"><?php
                        echo lang('product_price');
                    ?></td>
                    <td class="right"><?php
                        echo lang('product_subtotal');
                    ?></td>
                </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td class="left"><?php
                        echo anchor(
                            site_url('product/view/'.$product->product_id),
                            $product->product_code,
                            array('target' => '_blank')
                        );
                    ?></td>
                    <td class="left"><?php
                        echo anchor(
                            site_url('product/view/'.$product->product_id),
                            $product->product_name,
                            array('target' => '_blank')
                        );
                    ?></td>
                    <td class="right"><?php
                        echo $product->quantity;
                    ?></td>
                    <td class="right"><?php
                        echo to_currency($product->unit_sell_price, 'MYR');
                    ?></td>
                    <td class="right"><?php
                        echo to_currency($product->subtotal, 'MYR');
                    ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="right"><?php
                        echo label(lang('product_subtotal'));
                    ?></td>
                    <td class="right"><?php
                        echo to_currency($order->subtotal, 'MYR');
                    ?></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="right"><?php
                        echo label(lang('order_shipping'));
                    ?></td>
                    <td class="right"><?php
                        echo to_currency($order->shipping_cost, 'MYR');
                    ?></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="right"><?php
                        echo label(lang('product_grand_total'));
                    ?></td>
                    <td class="right"><?php
                        echo to_currency($order->grand_total, 'MYR');
                    ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="buttons">
            <div class="right"><?php
                echo button_link(
                    site_url('order'),
                    lang('back')
                );
            ?></div>
        </div>
    </form>
</div>
