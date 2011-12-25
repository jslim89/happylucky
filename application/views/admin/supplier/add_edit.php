<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'admin/supplier');
    });

    // Override the original paging link,
    // set the default tab to product orders
    $('div.inner_paging a').each(function() {
        var url = $(this).attr('href');
        $(this).attr('href', url+'.html?tab=1');
    });

    $('#supplier_add_edit').validationEngine('attach');

    var is_add_new = <?php echo empty($supplier->id) ? 'true' : 'false'; ?>;
    var tabs_disable = (is_add_new) ? [1] : [];
    var tabs_selected = (query_string('tab') == null) ? 0 : query_string('tab');
    $('#tabs').tabs({
        disabled: tabs_disable,
        selected: tabs_selected,
        ajaxOptions: {
            error: function(xhr, status, index, anchor) {
                $(anchor.hash).html(
                    "Tab broken"
                );
            }
        }
    });

    $('input#country').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/country/ajax_search',
        focus: function(event, ui) {
            $(this).val(ui.item.country_name);
            return false;
        },
        select: function(event, ui) {
            $(this).val(ui.item.country_name);
            $('input[name=country_id]').val(ui.item.id);
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
                .append('<a>' + format_country(item) + '</a>')
                .appendTo(ul);
    };

});
</script>

<div id="tabs">
    <ul>
        <li><a href="#general"><?php echo lang('general'); ?></a></li>
        <li>
            <a href="#ordered_products">
                <?php echo lang('supplier_orders'); ?>
            </a>
        </li>
    </ul>
    <div id="general">
        <form id="supplier_add_edit" method="POST" 
              action="<?php echo site_url("admin/supplier/save/".$supplier->id);?>">
            <table>
                <tr>
                    <td class="label"><?php echo lang('supplier_name');?></td>
                    <td colspan="3">
                        <?php 
                            echo form_input(array(
                                'name'  => 'supplier_name',
                                'id'    => 'supplier_name',
                                'value' => $supplier->supplier_name,
                                'class' => 'validate[required] text'
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('address');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'address',
                                'id'    => 'address',
                                'value' => $supplier->address,
                                'class' => 'validate[required]'
                            ));
                        ?>
                    </td>
                    <td><?php echo lang('town');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'town',
                                'id'    => 'town',
                                'value' => $supplier->town,
                                'class' => ''
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('postcode');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'postcode',
                                'id'    => 'postcode',
                                'value' => $supplier->postcode,
                                'class' => 'positive_integer'
                            ));
                        ?>
                    </td>
                    <td><?php echo lang('city');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'city',
                                'id'    => 'city',
                                'value' => $supplier->city,
                                'class' => 'validate[required]'
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('state');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'state',
                                'id'    => 'state',
                                'value' => $supplier->state,
                                'class' => 'validate[required]'
                            ));
                        ?>
                    </td>
                    <td><?php echo lang('country');?></td>
                    <td>
                        <?php 
                            $country = (sizeof($supplier->country) < 1)
                                ? new Country_Model() 
                                : $supplier->country;
                            echo form_input(array(
                                'name'  => 'country',
                                'id'    => 'country',
                                'value' => $country->country_name,
                                'class' => 'validate[required]'
                            ));
                            echo form_hidden('country_id', $supplier->country_id);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('supplier_contact');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'contact_no',
                                'id'    => 'contact_no',
                                'value' => $supplier->contact_no,
                                'class' => 'validate[required]'
                            ));
                        ?>
                    </td>
                    <td><?php echo lang('email');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'email',
                                'id'    => 'email',
                                'value' => $supplier->email,
                                'class' => 'validate[required,custom[email]]'
                            ));
                        ?>
                    </td>
                </tr>
            </table>
            <div class="right">
                <?php
                    echo form_button(array(
                        'id'      => 'back',
                        'content' => lang('back'),
                    ));
                    echo form_submit('save_supplier', lang('save'), 'class="button"');
                ?>
            </div>
        </form>
    </div>
    <div id="ordered_products">
        <!-- Pagination -->
        <div class="inner_paging">
            <?php echo $pagination->create_links().nbs(1);?>
        </div>
        <!-- End Pagination -->
        <table class="listing">
            <tr>
                <th width="5%"><?php
                    echo form_checkbox(array(
                        'name'  => 'check_all',
                        'id'    => 'check_all',
                        'value' => 'CHECK_ALL',
                    ));
                ?></th>
                <th><?php echo lang('image');?></th>
                <th><?php echo lang('product_code');?></th>
                <th><?php echo lang('product_name');?></th>
                <th><?php echo lang('product_cost');?></th>
                <th><?php echo lang('product_type');?></th>
            </tr>
            <?php foreach($products as $product):?>
            <tr id="product_row_<?php echo $product->id; ?>">
                <td><?php
                    echo form_checkbox(array(
                        'name'  => 'check_'.$product->id,
                        'id'    => 'check_'.$product->id,
                        'value' => $product->id,
                        'class' => 'delete_check',
                    ));
                ?></td>
                <td><?php 
                    $image_src = $product->primary_image_url
                        ? $product->primary_image_url
                        : default_image_path();
                    echo anchor(
                        site_url('admin/product/edit/'.$product->id),
                        img(array(
                            'src'    => $image_src,
                            'alt'    => $product->product_name,
                            'width'  => '100',
                            'height' => '100',
                        ))
                    );
                ?></td>
                <td><?php 
                    echo anchor(
                        site_url('admin/product/edit/'.$product->id),
                        $product->product_code
                    );
                ?></td>
                <td><?php 
                    echo anchor(
                        site_url('admin/product/edit/'.$product->id),
                        $product->product_name
                    );
                ?></td>
                <td><?php echo $product->cost;?></td>
                <td><?php echo $product->product_type;?></td>
                <td><?php 
                    echo (empty($product->supplier_id)) ? nbs(1) : anchor(
                        site_url('admin/supplier/edit/'.$product->supplier_id),
                        $product->supplier->supplier_name
                    );
                ?></td>
                <td>
                    <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                        <li class="ui-state-default ui-corner-all">
                            <span id="edit_<?php echo $product->id; ?>" class="ui-icon ui-icon-pencil"
                                title="<?php echo lang('edit');?>"></span>
                        </li>
                        <li class="ui-state-default ui-corner-all">
                            <span id="delete_<?php echo $product->id; ?>" class="ui-icon ui-icon-trash"
                                title="<?php echo lang('delete');?>"></span>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
