<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span#advanced_search').click(function() {
        $('div#advanced_search_dialog').dialog('open');
    });

    $('div#advanced_search_dialog').dialog({
        autoOpen: false,
        height: 300,
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
        echo form_open(site_url('product/index'), array('id' => 'advanced_search_form'));
        echo form_fieldset(lang('product'));
    ?>
        <table width="100%">
            <tr>
                <td width="50%"><?php
                    echo form_label(lang('product_code'), 'product_code');
                ?></td>
                <td width="50%"><?php
                    echo form_input(array(
                        'id'   => 'product_code',
                        'name' => 'product_code',
                ));?></td>
            </tr>
            <tr>
                <td width="50%"><?php
                    echo form_label(lang('product_name'), 'product_name');
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
                    echo form_label(lang('product_description'), 'product_desc');
                ?></td>
                <td width="50%"><?php
                    echo form_input(array(
                        'id'   => 'product_desc',
                        'name' => 'product_desc',
                    ));
                ?></td>
            </tr>
                <td width="50%"><?php
                    echo form_label(lang('product_standard_price'), 'standard_price');
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
                    echo form_label(lang('product_type'), 'product_type');
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
                    echo form_label(lang('product_category'), 'product_category');
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
<div class="grid_16">
    <?php echo $pagination->create_links().nbs(1);?>
</div>
<!-- End Pagination -->

<?php echo clear_div();?>

<div class="grid_16">
    <?php if(sizeof($products) == 0): ?>
        <span class="warning"><?php echo lang('product_no_product'); ?></span>
    <?php else: ?>
        <ul class="no-bullet product">
        <?php foreach($products as $product): ?>
        <li>
            <table id="product_list_<?php echo $product->id; ?>">
                <tr>
                    <td width="25%"><?php 
                        $product_url = site_url('product/view/'.$product->id);
                        echo anchor(
                            $product_url,
                            img(array(
                                'src'    => $product->primary_image_url,
                                'alt'    => $product->product_name,
                                'width'  => 80,
                                'height' => 80,
                            ))
                        );
                    ?></td>
                    <td width="*"><?php
                    echo anchor($product_url, $product->product_code.' - '.$product->product_name);
                    echo br(1);
                    echo '<span class="expander">'.$product->product_desc.'</span>';
                    ?></td>
                    <td width="10%"><?php
                        echo 'RM'.$product->standard_price;
                    ?></td>
                    <td width="10%"><?php
                        echo form_button(array(
                            'id' => 'add_to_cart_'.$product->id,
                            'content' => lang('add_to_cart'),
                            'onclick' => 'add_to_cart('.$product->id.')'
                        ));
                    ?></td>
                </tr>
            </table>
        </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
