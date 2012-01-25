<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#back').click(function() {
        redirect(base_url+'admin/order');
    });

    $('#save_form_order').click(function() {
        $('#form_order').submit();
    });

    $('#form_order').validationEngine('attach');

    $('#btn_send_email').click(function() {
        $('span#spinner_email').show();
        $.ajax({
            url: base_url + 'admin/order/send_email_acknowledge_customer/<?php echo $order->id; ?>',
            dataType: 'json',
            success: function(data) {
                if(data.status == true) {
                    $('#email_sent').show();
                    $('#email_failed').hide();
                }
                else {
                    $('#email_sent').hide();
                    $('#email_failed').show();
                }
            },
            complete: function(jqXHR, textStatus) {
                $('span#spinner_email').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
});

</script>

<form id="form_order" method="POST" 
      action="<?php echo site_url("admin/order/save/".$order->id);?>">
    <div class="box grid_8">
        <div class="box-heading"><?php
            echo lang('order_details');
        ?></div>
        <div class="box-content">
            <table class="form">
                <tr>
                    <td class="label"><?php echo lang('order_order_date');?></td>
                    <td><?php 
                        echo to_human_date_time($order->order_date);
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('order_subtotal');?></td>
                    <td><?php 
                        echo to_currency($order->subtotal, 'MYR');
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('order_shipping');?></td>
                    <td><?php 
                        echo to_currency($order->shipping, 'MYR');
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('order_total');?></td>
                    <td><?php 
                        echo to_currency($order->grand_total, 'MYR');
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="box grid_7">
        <div class="box-heading"><?php
            echo lang('order_payment_details');
        ?></div>
        <div class="box-content">
            <table class="form">
                <tr>
                    <td class="label"><?php echo lang('order').' '.lang('order_status');?></td>
                    <td><?php 
                        if($order->is_completed()) {
                            echo Customer_Order_Model::status($order->order_status);
                        }
                        else {
                            echo form_dropdown(
                                'order_status',
                                Customer_Order_Model::get_dropdown_list(),
                                $order->order_status
                            );
                        }
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('order_payment_date');?></td>
                    <td><?php 
                        if($order->is_completed()) {
                            echo to_human_date($order->order_date);
                        }
                        else {
                            echo form_input(array(
                                'id'    => 'payment_date',
                                'name'  => 'payment_date',
                                'value' => to_human_date($order->payment_date),
                                'class' => 'date',
                            ));
                        }
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('order_payment_method');?></td>
                    <td><?php 
                        echo $order->payment_method();
                    ?></td>
                </tr>
                <?php if($order->payment_method() === Customer_Order_Model::BANK_IN): ?>
                <tr>
                    <td><?php echo lang('order_bank_account_no');?></td>
                    <td><?php 
                        echo $order->recipient_bank_acc;
                    ?></td>
                </tr>
                <?php endif; ?>
            </table>
            <?php if( ! $order->is_completed()): ?>
            <div class="buttons">
                <div class="right"><?php
                    echo button_link(
                        false,
                        lang('save'),
                        array('id' => 'save_form_order')
                    );
                ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php echo clear_div(); ?>
    <div class="box grid_15">
        <div class="box-heading"><?php
            echo lang('order_shipping_information');
        ?></div>
        <div class="box-content">
            <table class="form">
                <tr>
                    <td class="label"><?php echo lang('order_customer_name');?></td>
                    <td><?php 
                        if($order->is_member_order()) {
                            $name = anchor(
                                site_url('admin/customer/edit/'.$order->customer_id),
                                $order->first_name.", ".$order->last_name
                            );
                        }
                        else {
                            $name = $order->first_name.", ".$order->last_name;
                        }
                        echo $name;
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('order_contact_no');?></td>
                    <td><?php 
                        echo $order->shipping_contact_no;
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('address');?></td>
                    <td><?php 
                        echo ($order->get_full_address());
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php echo clear_div(); ?>
    <div class="box grid_15">
        <div class="box-heading"><?php
            echo lang('products');
        ?></div>
        <div class="box-content">
            <table class="list">
                <thead>
                    <tr>
                        <td><?php echo lang('product_name');?></td>
                        <td><?php echo lang('cart_quantity');?></td>
                        <td><?php echo lang('cart_unit_price');?></td>
                        <td><?php echo lang('cart_total');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product):?>
                    <tr>
                        <td><?php 
                            echo anchor(
                                site_url('admin/product/edit/'.$product->id),
                                $product->product_code.' - '.$product->product_name
                            );
                        ?></td>
                        <td><?php
                            echo $product->quantity;
                        ?></td>
                        <td><?php
                            echo to_currency($product->unit_sell_price);
                        ?></td>
                        <td><?php
                            echo to_currency($product->subtotal);
                        ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><?php
                            echo lang('order_subtotal').nbs(1);
                        ?></td>
                        <td><?php
                            echo to_currency($order->subtotal, 'MYR');
                        ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><?php
                            echo lang('order_shipping').nbs(1);
                        ?></td>
                        <td><?php
                            echo to_currency($order->shipping_cost, 'MYR');
                        ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><?php
                            echo lang('order_total').nbs(1);
                        ?></td>
                        <td><?php
                            echo to_currency($order->grand_total, 'MYR');
                        ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php echo clear_div(); ?>
    <div id="email_failed" class="warning" style="display: none;"><?php
        echo lang('order_email_failed_to_send');
    ?></div>
    <div id="email_sent" class="success" style="display: none;"><?php
        echo lang('order_email_sent');
    ?></div>
    <div class="buttons">
        <div class="left"><?php
            echo button_link(
                site_url('admin/order/add_products/'.$order->id),
                lang('order_add_products_to_this_order'),
                array('id' => 'btn_add_product')
            );
            echo nbs(2);
            echo button_link(
                false,
                lang('order_send_email_acknowledge_customer'),
                array('id' => 'btn_send_email')
            );
            echo spinner('spinner_email');
        ?></div>
        <div class="right"><?php
            echo button_link(
                false,
                lang('back'),
                array('id' => 'back')
            );
        ?></div>
    </div>
</form>
