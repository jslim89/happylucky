<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
});
</script>

<?php echo clear_div();?>

<!-- Search box -->
<div class="grid_16 search">
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
