<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'admin/product');
    });

    $('#product_add_edit').validationEngine('attach');
    var is_add_new = <?php echo empty($product->id) ? 'true' : 'false'; ?>;
    var tabs_disable = (is_add_new) ? [1] : [];
    var tabs_selected = (query_string('tab') == null) ? 0 : query_string('tab');
    $('#tabs').tabs({
        disabled: tabs_disable,
        selected: tabs_selected
    });

    check_is_amulet();

    $('input#is_amulet').change(function() {
        if($(this).is(':checked')) {
            $('.amulet_info').show(3000);
            add_amulet_info_validation();
        }
        else {
            $('.amulet_info').hide(3000);
            remove_amulet_info_validation();
        }
    });

    $('input#amulet').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/amulet/ajax_search',
        focus: function(event, ui) {
            amulet_value = format_amulet(ui.item);
            $(this).val(amulet_value);
            return false;
        },
        select: function(event, ui) {
            amulet_value = format_amulet(ui.item);
            $(this).val(amulet_value);
            $('input[name=amulet_id]').val(ui.item.id);
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
                .append('<a>' + format_amulet(item) + '</a>')
                .appendTo(ul);
    };

    $('input#supplier').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/supplier/ajax_search',
        focus: function(event, ui) {
            $(this).val(ui.item.supplier_name);
            return false;
        },
        select: function(event, ui) {
            $(this).val(ui.item.supplier_name);
            $('input[name=supplier_id]').val(ui.item.id);
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
                .append('<a>' + item.supplier_name + '</a>')
                .appendTo(ul);
    };
});

function check_is_amulet() {
    var is_amulet = <?php echo empty($product->amulet_product_id) ? 'false' : 'true'; ?>;
    if(is_amulet) {
        $('.amulet_info').show();
        add_amulet_info_validation();
    }
    else {
        $('.amulet_info').hide();
        remove_amulet_info_validation();
    }
}

function add_amulet_info_validation() {
    $('input#amulet').addClass('validate[required]');
    $('input#ingredient').addClass('validate[required]');
    $('input#size').addClass('validate[required]');
}

function remove_amulet_info_validation() {
    $('input#amulet').removeClass('validate[required]');
    $('input#ingredient').removeClass('validate[required]');
    $('input#size').removeClass('validate[required]');
}

function format_amulet(amulet) {
    var str = amulet.amulet_code
            + ' - '
            + amulet.amulet_name;
    return str;
}
</script>

<div id="tabs">
    <ul>
        <li><a href="#general"><?php echo lang('general'); ?></a></li>
        <li><a href="#images"><?php echo lang('images'); ?></a></li>
    </ul>
    <div id="general">
        <form id="product_add_edit" method="POST" 
              action="<?php echo site_url("admin/product/save/".$product->id);?>">
            <table>
                <tr>
                    <td class="label"><?php echo lang('product_code');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'product_code',
                                'id'    => 'product_code',
                                'value' => $product->product_code,
                                'class' => 'validate[required,ajax[ajaxProductCode]] text'
                            ));
                    ?></td>
                    <td class="label"><?php echo lang('product_name');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'product_name',
                                'id'    => 'product_name',
                                'value' => $product->product_name,
                                'class' => 'validate[required] text'
                            ));
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('product_cost');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'cost',
                                'id'    => 'cost',
                                'value' => $product->cost,
                                'class' => 'validate[required] text positive'
                            ));
                    ?></td>
                    <td class="label"><?php echo lang('product_standard_price');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'standard_price',
                                'id'    => 'standard_price',
                                'value' => $product->standard_price,
                                'class' => 'validate[required] text positive'
                            ));
                    ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('product_quantity_available');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'quantity_available',
                                'id'    => 'quantity_available',
                                'value' => $product->quantity_available,
                                'class' => 'validate[required] text positive-integer'
                            ));
                    ?></td>
                    <td class="label"><?php echo lang('product_minimum_quantity_alert');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'min_qty_alert',
                                'id'    => 'min_qty_alert',
                                'value' => $product->min_qty_alert,
                                'class' => 'validate[required] text positive-integer',
                                'title' => lang('product_min_qty_alert_desc')
                            ));
                            echo br(1);
                    ?>
                        <span class="attr-desc">
                        <?php echo lang('product_min_qty_alert_desc');?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('product_min_quantity');?></td>
                    <td><?php 
                            // By default the minimum quantity to order is 1
                            echo form_input(array(
                                'name'  => 'min_quantity',
                                'id'    => 'min_quantity',
                                'value' => $product->min_quantity ? $product->min_quantity : 1,
                                'class' => 'validate[required] text positive'
                            ));
                    ?></td>
                    <td class="label"><?php echo lang('product_type');?></td>
                    <td><?php 
                            if($product->is_exist()) {
                                $type_retail_checked = ($product->product_type === Product_Model::RETAIL);
                                $type_wholesale_checked = ( ! $type_retail_checked);
                            }
                            else {
                                $type_retail_checked      = TRUE;
                                $type_wholesale_checked = FALSE;
                            }
                            echo form_radio(array(
                                'name'    => 'product_type',
                                'id'      => 'type_retail',
                                'checked' => $type_retail_checked,
                                'value'   => Product_Model::RETAIL,
                                'class'   => 'radio'
                            ));
                            echo lang('product_retail');
                            echo form_radio(array(
                                'name'    => 'product_type',
                                'id'      => 'type_wholesale',
                                'checked' => $type_wholesale_checked,
                                'value'   => Product_Model::WHOLESALE,
                                'class'   => 'radio'
                            ));
                            echo lang('product_wholesale');
                    ?></td>
                </tr>
                <tr>
                    <td class="txt-label"><?php echo lang('product_from_supplier');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'supplier',
                                'id'    => 'supplier',
                                'value' => $supplier->supplier_name,
                                'class' => 'validate[required]'
                            ));
                            echo form_hidden('supplier_id', $product->supplier_id);
                    ?></td>
                    <td class="txt-label"><?php echo lang('product_created_date');?></td>
                    <td><?php echo to_human_date($product->created_date); ?></td>
                </tr>
                <tr>
                    <td class="txt-label"><?php echo lang('product_description');?></td>
                    <td colspan="3"><?php 
                            echo form_textarea(array(
                                'name'  => 'product_desc',
                                'id'    => 'product_desc',
                                'value' => $product->product_desc,
                                'class' => 'validate[required] wysiwyg'
                            ));
                    ?></td>
                </tr>
                <?php if( ! $product->is_exist()): // show only if it is ADD NEW?>
                <tr>
                    <td class="label"><?php echo lang('product_is_it_an_amulet');?></td>
                    <td><?php 
                            echo form_checkbox(array(
                                'name'    => 'is_amulet',
                                'id'      => 'is_amulet',
                                'value'   => TRUE,
                                'checked' => FALSE,
                                'class'   => 'checkbox'
                            ));
                    ?></td>
                </tr>
                <?php endif; ?>
                <tr class="amulet_info">
                    <td colspan="4" class="txt-label"><?php echo lang('amulet');?></td>
                </tr>
                <tr class="amulet_info">
                    <td class="label"><?php echo lang('product_size');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'size',
                                'id'    => 'size',
                                'value' => $amulet_product->size,
                                'class' => 'validate[required]'
                            ));
                    ?></td>
                    <td class="label"><?php echo lang('product_ingredient');?></td>
                    <td><?php 
                            echo form_input(array(
                                'name'  => 'ingredient',
                                'id'    => 'ingredient',
                                'value' => $amulet_product->ingredient,
                                'class' => 'validate[required]'
                            ));
                    ?></td>
                </tr>
                <tr class="amulet_info">
                    <td class="label"><?php echo lang('amulet');?></td>
                    <td colspan="3"><?php 
                            echo form_input(array(
                                'name'  => 'amulet',
                                'id'    => 'amulet',
                                'value' => $amulet_product->is_exist() 
                                    ? $amulet_product->amulet->amulet_name
                                    : "",
                                'class' => 'validate[required]'
                            ));
                            echo form_hidden('amulet_id', $amulet_product->amulet_id);
                    ?></td>
                </tr>
            </table>
            <div class="right">
                <?php
                    echo form_button(array(
                        'id'      => 'back',
                        'content' => lang('back'),
                    ));
                    echo form_submit('save_product', lang('save'), 'class="button"');
                ?>
            </div>
        </form>
    </div>
    <div id="images">
        <?php $this->load->view('common/admin_images', $image_upload);?>
    </div>
</div>
