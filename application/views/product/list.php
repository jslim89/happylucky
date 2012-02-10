<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span#advanced_search').click(function() {
        $('div#advanced_search_dialog').dialog('open');
    });

    $('div#advanced_search_dialog').dialog({
        autoOpen: false,
        height: 350,
        width: 500,
        modal: true,
        buttons: {
            <?php echo lang('search');?>: function() {
                $('form#advanced_search_form').submit();
            },
            <?php echo lang('close');?>: function() {
                $(this).dialog('close');
            }
        },
    });
});
</script>

<?php echo clear_div();?>

<!-- Search box -->
<div class="grid_16 search">
    <div id="advanced_search_dialog" title="<?php echo lang('advanced_search');?>">
    <?php
        echo form_open(site_url('product/index').'?search_type=advanced', array('id' => 'advanced_search_form'));
        echo form_fieldset(lang('product'));
    ?>
        <table class="form" width="100%">
            <tr>
                <td width="50%"><?php
                    echo form_label(label(lang('product_code')), 'product_code');
                ?></td>
                <td width="50%"><?php
                    echo form_input(array(
                        'id'   => 'product_code',
                        'name' => 'product_code',
                ));?></td>
            </tr>
            <tr>
                <td width="50%"><?php
                    echo form_label(label(lang('product_name')), 'product_name');
                ?></td>
                <td width="50%"><?php
                    echo form_input(array(
                        'id'   => 'product_name',
                        'name' => 'product_name',
                    ));
                ?></td>
            </tr>
            <tr>
                <td width="50%"><?php
                    echo form_label(label(lang('product_description')), 'product_desc');
                ?></td>
                <td width="50%"><?php
                    echo form_input(array(
                        'id'   => 'product_desc',
                        'name' => 'product_desc',
                    ));
                ?></td>
            </tr>
                <td width="50%"><?php
                    echo form_label(label(lang('product_standard_price')), 'standard_price');
                ?></td>
                <td width="50%"><?php
                    $operator_option = array(
                        Product_Model::EQUAL         => '=',
                        Product_Model::LESS_EQUAL    => '<=',
                        Product_Model::LESS          => '<',
                        Product_Model::GREATER_EQUAL => '>=',
                        Product_Model::GREATER       => '>',
                    );
                    echo form_dropdown('operator', $operator_option);
                    echo form_input(array(
                        'id'    => 'standard_price',
                        'name'  => 'standard_price',
                        'class' => 'positive',
                    ));
                ?></td>
            </tr>
                <td width="50%"><?php
                    echo form_label(label(lang('product_type')), 'product_type');
                ?></td>
                <td width="50%"><?php
                    $type_option = array(
                        Product_Model::BOTH      => '',
                        Product_Model::RETAIL    => lang('product_retail'),
                        Product_Model::WHOLESALE => lang('product_wholesale'),
                    );
                    echo form_dropdown('product_type', $type_option, strtoupper(get_post('type')), 'id="type"');
                ?></td>
            </tr>
                <td width="50%"><?php
                    echo form_label(label(lang('product_category')), 'product_category');
                ?></td>
                <td width="50%"><?php
                    $category_option = array(
                        Product_Model::BOTH        => '',
                        Product_Model::AMULET      => lang('amulet'),
                        Product_Model::ACCESSORIES => lang('product_accessories'),
                    );
                    echo form_dropdown('product_category', $category_option, strtoupper(get_post('category')), 'id="cagegory"');
                ?></td>
            </tr>
        </table>
    <?php
    echo form_fieldset_close();
    echo form_close();
    ?>
    </div>
    <span id="advanced_search" class="hand-cursor" style="color:blue; float:left;">
        <?php echo lang('advanced_search'); ?>
    </span>
    <?php
    $this->load->view('common/search_form', $search_form_info);
    ?>
</div>
<!-- End Search box -->

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_16 pagination">
    <span class="pagin"><?php
        echo $pagin;
    ?></span>
    <?php
        echo lang('page').nbs(2);
        echo $pagination->create_links().nbs(1);
    ?>
</div>
<!-- End Pagination -->

<?php echo clear_div();?>

<?php if(sizeof($products) == 0): ?>
    <div class="grid_16">
        <div class="warning"><?php echo lang('product_no_product'); ?></div>
    </div>
<?php echo clear_div();?>
<?php else: ?>
    <hr />
    <?php foreach($products as $product): ?>
    <div id="product_<?php echo $product->id;?>" style="margin-bottom: 3; margin-top: 3">
        <div class="grid_3"><?php
            $product_url = site_url('product/view/'.$product->id);
            $image_url = empty($product->primary_image_url)
                ? default_image_path()
                : $product->primary_image_url;
            echo anchor(
                $product_url,
                img(array(
                    'src'    => $image_url,
                    'alt'    => $product->product_name,
                    'width'  => 80,
                    'height' => 80,
                ))
            );
        ?></div>
        <div class="grid_7"><?php
            echo anchor($product_url, $product->product_code.' - '.$product->product_name);
            echo br(1);
            echo '<span class="expander">'.$product->product_desc.'</span>';
        ?></div>
        <div class="grid_2"><?php
            echo 'RM'.$product->standard_price;
        ?></div>
        <div class="grid_3"><?php
            echo div('', array(
                'class' => 'warning add_to_cart_status_'.$product->id,
                'style' => 'display: none;',
            ));
            echo button_link(
                false,
                lang('add_to_cart'),
                array(
                    'id'      => 'add_to_cart_'.$product->id,
                    'onclick' => 'add_to_cart('.$product->id.', '.$product->min_quantity.')'
                )
            );
            $min_qty_to_add = '('.lang('cart_min_quantity_to_add')
                .': '.$product->min_quantity.')';
            echo div($min_qty_to_add, array(
                'class' => 'min_qty_add hint',
            ));
        ?></div>
    <?php echo clear_div(); ?>
    </div>
    <hr />
    <?php endforeach; ?>
<?php endif; ?>
