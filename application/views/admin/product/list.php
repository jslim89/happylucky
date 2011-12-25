<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span[id^=edit_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            redirect('product/edit/'+id);
        });
    });
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

    /*
    $('span#advanced_search').click(function() {
    });
     */
});
</script>

<!-- Search box -->
<div class="grid_16 search">
    <?php
    $this->load->view('common/search_form', $search_form_info);
    ?>
</div>
<!-- End Search box -->

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
    <input type="button" class="button" 
        value="<?php echo lang('add_new');?>" 
        onclick="redirect('<?php echo site_url('admin/product/add');?>');" />
</div>
<!-- End Action Button -->
<?php echo clear_div();?>

<div class="grid_16">
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
            <th><?php echo lang('product_quantity_available');?></th>
            <th><?php echo lang('product_cost');?></th>
            <th><?php echo lang('product_standard_price');?></th>
            <th><?php echo lang('product_type');?></th>
            <th><?php echo lang('product_from_supplier');?></th>
            <th><?php echo lang('edit');?></th>
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
            <td><?php echo $product->quantity_available;?></td>
            <td><?php echo $product->cost;?></td>
            <td><?php echo $product->standard_price;?></td>
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
