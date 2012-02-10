<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#back').click(function() {
        redirect(base_url+'admin/order');
    });

    $('#save_order_add').click(function() {
        $('#order_add').submit();
    });

    $('#order_add').validationEngine('attach');

    $('input#is_existing_customer').change(function() {
        if($(this).is(':checked')) {
            $('#tr_search_customer').show(2000);
            $('#tr_existing_address').show(2000);
        }
        else {
            $('#tr_search_customer').hide(2000);
            $('#tr_existing_address').hide(2000);
            $('input[name=customer_id]').val('');
        }
    });

    $('input#use_existing_address').change(function() {
        if($(this).is(':checked')) {
            var id = $('input[name=customer_id]').val();
            if(id == null || id == '') {
                ui_alert(lang_warning, lang_please_select_an_existing_customer);
                $(this).attr('checked', false);
            }
            else {
                $.ajax({
                    url: base_url+'user/get_details_in_json/'+id,
                    dataType: 'json',
                    success: function(data) {
                        $('input#shipping_address').val(data.address).attr('readonly', true);
                        $('input#shipping_town').val(data.town).attr('readonly', true);
                        $('input#shipping_postcode').val(data.postcode).attr('readonly', true);
                        $('input#shipping_city').val(data.city).attr('readonly', true);
                        $('input#shipping_state').val(data.state).attr('readonly', true);
                        $('select#shipping_country_id').val(data.country_id).attr('readonly', true);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }
        }
        else {
            $('table#address_info input[name^=shipping_]').each(function() {
                $(this).val('').attr('readonly', false);
            });
            $('select#shipping_country_id').val('129');
        }
    });

    $('input#search_customer').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/customer/ajax_search',
        focus: function(event, ui) {
            customer_value = ui.item.first_name + ' ' + ui.item.last_name;
            $(this).val(customer_value);
            return false;
        },
        select: function(event, ui) {
            customer_value = ui.item.first_name + ' ' + ui.item.last_name;
            $(this).val(customer_value);
            $('input[name=customer_id]').val(ui.item.id);

            /* Populate to textbox */
            $('#first_name').val(ui.item.first_name);
            $('#last_name').val(ui.item.last_name);
            $('#email').val(ui.item.email);
            $('#shipping_contact_no').val(ui.item.contact_no);

            return false;
        },
        open: function() {
            $(this).removeClass('ui-corner-all').addClass('ui-corner-top');
        },
        close: function() {
            $(this).removeClass('ui-corner-top').addClass('ui-corner-all');
        }
    })
    .data('autocomplete')._renderItem = function(ul, item){
        return $('<li></li>')
                .data('item.autocomplete', item)
                .append('<a>' + format_customer(item) + '</a>')
                .appendTo(ul);
    };
});

function format_customer(customer) {
    var str = customer.first_name + ' ' +customer.last_name;
    str += '<br />' + customer.email;
    return str;
}

</script>

<form id="order_add" method="POST" 
      action="<?php echo site_url("admin/order/save/".$order->id);?>">
    <div class="box grid_8">
        <div class="box-heading"><?php
            echo lang('order_customer_information');
        ?></div>
        <div class="box-content">
            <table class="form">
                <tr>
                    <td colspan="2"><?php
                        echo form_checkbox(array(
                            'id' => 'is_existing_customer',
                        ));
                        echo lang('order_existing_customer').'?';
                    ?></td>
                </tr>
                <tr id="tr_search_customer" style="display: none;">
                    <td class="label"><?php echo lang('order_search_for_customer');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'search_customer',
                        ));
                        echo form_hidden('customer_id', '');
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo required_indicator().lang('user_first_name');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'first_name',
                            'name'  => 'first_name',
                            'class' => 'validate[required]',
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo required_indicator().lang('user_last_name');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'last_name',
                            'name'  => 'last_name',
                            'class' => 'validate[required]',
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo required_indicator().lang('email');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'email',
                            'name'  => 'email',
                            'class' => 'validate[required,custom[email]]',
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo required_indicator().lang('order_contact_no');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'shipping_contact_no',
                            'name'  => 'shipping_contact_no',
                            'class' => 'validate[required]',
                        ));
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
                    <td class="label"><?php echo required_indicator().lang('order').' '.lang('order_status');?></td>
                    <td><?php 
                        echo form_dropdown(
                            'order_status',
                            Customer_Order_Model::get_dropdown_list()
                        );
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo required_indicator().lang('order_order_date');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'order_date',
                            'name'  => 'order_date',
                            'class' => 'date validate[required]',
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('order_payment_date');?></td>
                    <td><?php 
                        echo form_input(array(
                            'id'    => 'payment_date',
                            'name'  => 'payment_date',
                            'class' => 'date',
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo required_indicator().lang('order_payment_method');?></td>
                    <td><?php 
                        $payment_method_list = array(
                            Customer_Order_Model::CASH_ON_DELIVERY => Customer_Order_Model::CASH_ON_DELIVERY,
                            Customer_Order_Model::BANK_IN          => Customer_Order_Model::BANK_IN,
                        );
                        echo form_dropdown(
                            'payment_method',
                            $payment_method_list
                        );
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php echo clear_div(); ?>
    <div class="box grid_15">
        <div class="box-heading"><?php
            echo lang('order_shipping_information');
        ?></div>
        <div class="box-content">
            <table class="form" id="address_info">
                <tr id="tr_existing_address" style="display: none;">
                    <td colspan="4"><?php
                        echo form_checkbox(array(
                            'id' => 'use_existing_address',
                        ));
                        echo lang('cart_use_existing_address').'.';
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo required_indicator().lang('address');?></td>
                    <td><?php 
                        echo form_input(array(
                            'name'  => 'shipping_address',
                            'id'    => 'shipping_address',
                            'class' => 'validate[required]'
                        ));
                    ?></td>
                    <td><?php echo lang('town');?></td>
                    <td><?php 
                        echo form_input(array(
                            'name'  => 'shipping_town',
                            'id'    => 'shipping_town',
                            'class' => ''
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('postcode');?></td>
                    <td><?php 
                        echo form_input(array(
                            'name'  => 'shipping_postcode',
                            'id'    => 'shipping_postcode',
                            'class' => ''
                        ));
                    ?></td>
                    <td><?php echo required_indicator().lang('city');?></td>
                    <td><?php 
                        echo form_input(array(
                            'name'  => 'shipping_city',
                            'id'    => 'shipping_city',
                            'class' => 'validate[required]'
                        ));
                    ?></td>
                </tr>
                <tr>
                    <td><?php echo required_indicator().lang('state');?></td>
                    <td><?php 
                        echo form_input(array(
                            'name'  => 'shipping_state',
                            'id'    => 'shipping_state',
                            'class' => 'validate[required]'
                        ));
                    ?></td>
                    <td><?php echo required_indicator().lang('country');?></td>
                    <td><?php 
                        echo form_dropdown(
                            'shipping_country_id',
                            Country_Model::get_dropdown_list(),
                            129
                        );
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php echo clear_div(); ?>
    <div class="buttons">
        <div class="right"><?php
            echo button_link(
                false,
                lang('back'),
                array('id' => 'back')
            );
            echo nbs(2);
            echo button_link(
                false,
                lang('save'),
                array('id' => 'save_order_add')
            );
        ?></div>
    </div>
</form>
