<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#back').click(function() {
        redirect(base_url+'admin/supplier');
    });

    $('#save_supplier_add_edit').click(function() {
        $('#supplier_add_edit').submit();
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
            <table class="form">
                <tr>
                    <td class="label"><?php echo required_indicator().lang('supplier_name');?></td>
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
                    <td><?php echo required_indicator().lang('address');?></td>
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
                    <td><?php echo required_indicator().lang('city');?></td>
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
                    <td><?php echo required_indicator().lang('state');?></td>
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
                    <td><?php echo required_indicator().lang('country');?></td>
                    <td>
                        <?php 
                            $country_selected = (sizeof($supplier->country) < 1)
                                ? 129 // Default is Malaysia
                                : $supplier->country_id;
                            echo form_dropdown(
                                'country_id',
                                Country_Model::get_dropdown_list(),
                                $country_selected
                            );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo required_indicator().lang('email');?></td>
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
                    <td><?php echo required_indicator().lang('supplier_contact');?></td>
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
                </tr>
                <tr>
                    <td><?php echo lang('supplier_fax');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'fax',
                                'id'    => 'fax',
                                'value' => $supplier->fax,
                                'class' => ''
                            ));
                        ?>
                    </td>
                    <td><?php echo required_indicator().lang('supplier_contact_person');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'contact_person',
                                'id'    => 'contact_person',
                                'value' => $supplier->contact_person,
                                'class' => 'validate[required]'
                            ));
                        ?>
                    </td>
                </tr>
            </table>
            <div class="buttons">
                <div class="right">
                    <?php
                        echo button_link(
                            false,
                            lang('back'),
                            array('id' => 'back')
                        );
                        echo nbs(2);
                        echo button_link(
                            false,
                            lang('save'),
                            array('id' => 'save_supplier_add_edit')
                        );
                    ?>
                </div>
            </div>
        </form>
    </div>
    <div id="ordered_products">
    <!-- Display only if the action is EDIT -->
    <?php if($supplier->is_exist()): ?>
        <!-- Pagination -->
        <div class="pagination inner_paging">
            <span class="pagin"><?php
                echo $pagin;
            ?></span>
            <?php
                echo lang('page').nbs(2);
                echo $pagination->create_links().nbs(1);
            ?>
        </div>
        <!-- End Pagination -->
        <table class="list">
            <thead>
                <tr>
                    <td><?php echo lang('image');?></td>
                    <td><?php echo lang('product_code');?></td>
                    <td><?php echo lang('product_name');?></td>
                    <td><?php echo lang('product_stock_in_date');?></td>
                    <td><?php echo lang('product_unit_cost');?></td>
                    <td><?php echo lang('product_quantity_stock_in');?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product):?>
                <tr id="product_row_<?php echo $product->id; ?>">
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
                    <td><?php echo to_human_date($product->stock_in_date);?></td>
                    <td><?php echo to_currency($product->unit_cost);?></td>
                    <td><?php echo $product->quantity_stock_in;?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
</div>
