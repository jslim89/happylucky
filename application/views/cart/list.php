<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#cart_form').validationEngine('attach');
    $('span[id^=delete_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this).parentsUntil('tr').parent());
            var rowid = get_element_index($(this));
            var delete_url = base_url + 'cart/remove/' + rowid;
            delete_row_confirmation(delete_url, 'cart_row_'+id);
        });
    });

    $('#btn_delete').click(function() {
        var delete_urls = [];
        var row_ids     = [];
        $.each($('.delete_check:checked'), function(i) {
            var id = $(this).val();
            var rowid = get_element_index($(this));
            row_ids[id]     = 'cart_row_'+id;
            delete_urls[id] = base_url + 'cart/remove/' + rowid;
        });
        delete_row_confirmation(delete_urls, row_ids);
    });

});
</script>

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_10">
    <?php echo $pagination->create_links().nbs(1);?>
</div>
<!-- End Pagination -->

<!-- Action Button -->
<div class="grid_5 right action-button"><?php
echo button_link(
    false,
    lang('delete'),
    array('id' => 'btn_delete')
);
?></div>
<!-- End Action Button -->
<?php echo clear_div();?>

<div class="grid_16">
    <form id="cart_form" method="POST" action="<?php echo site_url('cart/update');?>">
        <div class="cart-info">
            <table class="listing" width="100%">
                <thead>
                    <tr>
                        <td width="5%"><?php
                            echo form_checkbox(array(
                                'name'  => 'check_all',
                                'id'    => 'check_all',
                                'value' => 'CHECK_ALL',
                            ));
                        ?></td>
                        <td class="image"><?php echo lang('image');?></td>
                        <td><?php echo lang('product_code');?></td>
                        <td class="name"><?php echo lang('product_name');?></td>
                        <td class="quantity"><?php echo lang('cart_quantity');?></td>
                        <td class="price"><?php echo lang('cart_unit_price');?></td>
                        <td class="total"><?php echo lang('cart_total');?></td>
                        <td><?php echo lang('delete');?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total = 0;
                        foreach($products as $rowid => $product):
                    ?>
                    <tr id="cart_row_<?php echo $product->id; ?>">
                        <td class="remove"><?php
                            echo form_hidden('rowid['.$product->id.']', $rowid);
                            echo form_checkbox(array(
                                'name'  => 'check_'.$rowid,
                                'id'    => 'check_'.$rowid,
                                'value' => $product->id,
                                'class' => 'delete_check',
                            ));
                        ?></td>
                        <td class="image"><?php 
                            $image_src = $product->primary_image_url
                                ? $product->primary_image_url
                                : default_image_path();
                            echo anchor(
                                site_url('product/edit/'.$product->id),
                                img(array(
                                    'src'    => $image_src,
                                    'alt'    => $product->product_name,
                                    'width'  => '100',
                                    'height' => '100',
                                ))
                            );
                        ?></td>
                        <td class="code"><?php 
                            echo anchor(
                                site_url('product/view/'.$product->id),
                                $product->product_code
                            );
                        ?></td>
                        <td class="name"><?php 
                            echo anchor(
                                site_url('product/view/'.$product->id),
                                $product->product_name
                            );
                        ?></td>
                        <td class="quantity"><?php
                            $qty_validation = 'max['.$product->quantity_available.']'
                                            .',min['.$product->min_quantity.']';
                            echo form_input(array(
                                'id'    => 'quantity',
                                'name'  => 'quantity['.$product->id.']',
                                'value' => $product->qty,
                                'class' => 'positive-integer validate[required,'.$qty_validation.']',
                            ));
                            echo div(lang('product_quantity_available').': '.$product->quantity_available, array(
                                'class' => 'min_qty_add hint',
                            ));
                            $min_qty_to_add = '('.lang('cart_min_quantity_to_add')
                                .': '.$product->min_quantity.')';
                            echo div($min_qty_to_add, array(
                                'class' => 'min_qty_add hint',
                            ));
                            ?>
                        </td>
                        <td class="price"><?php echo to_currency($product->standard_price);?></td>
                        <td class="price"><?php
                            echo to_currency($product->subtotal);
                            $total += $product->subtotal;
                        ?></td>
                        <td>
                            <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                                <li class="ui-state-default ui-corner-all">
                                    <span id="delete_<?php echo $rowid; ?>" class="ui-icon ui-icon-trash"
                                        title="<?php echo lang('delete');?>"></span>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="cart-total">
        <table width="100%">
            <tr>
                <td colspan="5" width="70%">&nbsp;</td>
                <td class="right"><?php echo label(lang('cart_sub_total'));?>: </td>
                <td class="right"><?php echo to_currency($total, 'MYR');?></td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td class="right"><?php echo label(lang('cart_shipping'));?>: </td>
                <td class="right"><?php echo to_currency(0.00, 'MYR');?></td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td class="right"><?php echo label(lang('cart_total'));?>: </td>
                <td class="right"><?php echo to_currency($total, 'MYR');?></td>
            </tr>
        </table>
    </div>
    <div class="buttons">
        <div class="left">
            <a onclick="$('#cart_form').submit();" class="button">
                <span><?php echo lang('update'); ?></span>
            </a>
        </div>
        <div class="right"><?php
            echo button_link(
                site_url('cart/checkout'),
                lang('cart_check_out')
            );
        ?></div>
        <div class="center"><?php
            echo button_link(
                site_url(''),
                lang('cart_continue_shopping')
            );
        ?></div>
    </div>
</div>
