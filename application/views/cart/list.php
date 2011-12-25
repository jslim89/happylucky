<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#cart_form').validationEngine('attach');
    $('span[id^=delete_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            var delete_url = base_url + 'admin/product/delete/' + id;
            delete_row_confirmation(delete_url, 'product_row_'+id);
        });
    });

    $('#btn_delete').click(function() {
        var delete_urls = [];
        var row_ids     = [];
        $.each($('.delete_check:checked'), function(i) {
            var id = $(this).val();
            row_ids[id]     = 'product_row_'+id;
            delete_urls[id] = base_url + 'admin/product/delete/' + id;
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
<div class="grid_6 action-button">
    <input type="button" class="button" id="btn_delete" 
        value="<?php echo lang('delete');?>" />
</div>
<!-- End Action Button -->
<?php echo clear_div();?>

<div class="grid_16">
    <form id="cart_form" method="POST" action="">
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
                <th><?php echo lang('cart_quantity');?></th>
                <th><?php echo lang('cart_price');?></th>
                <th><?php echo lang('delete');?></th>
            </tr>
            <?php foreach($products as $rowid => $product):?>
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
                        site_url('product/edit/'.$product->id),
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
                        site_url('product/view/'.$product->id),
                        $product->product_code
                    );
                ?></td>
                <td><?php 
                    echo anchor(
                        site_url('product/view/'.$product->id),
                        $product->product_name
                    );
                ?></td>
                <td><?php
                    echo form_input(array(
                        'id'    => 'quantity',
                        'value' => $product->qty,
                        'class' => 'positive-integer validate[required,max['.$product->quantity_available.']]',
                    ));
                    echo br(1);
                    ?>
                    <span class="guide"><?php
                        echo lang('product_quantity_available').': '.$product->quantity_available;
                    ?></span>
                </td>
                <td><?php echo $product->standard_price;?></td>
                <td>
                    <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                        <li class="ui-state-default ui-corner-all">
                            <span id="delete_<?php echo $product->id; ?>" class="ui-icon ui-icon-trash"
                                title="<?php echo lang('delete');?>"></span>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </form>
</div>
