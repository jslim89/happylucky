<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'product');
    });
    $('button#add_to_cart').click(function() {
        var qty = $('input#quantity').val();
        add_to_cart(<?php echo $product->id; ?>, qty);
    })

    $('#product_form').validationEngine('attach');
});
</script>

<div id="product-content">
    <form id="product_form" method="POST">
        <table width="100%">
            <tr class="header">
                <td width="100%" colspan="2"><?php
                    echo $product->product_name;
                ?></td>
            </tr>
            <tr class="content">
                <td width="40%"><?php
                    echo anchor(
                        $product->primary_image_url,
                        img(array(
                            'src'    => $product->primary_image_url,
                            'alt'    => $product->product_name,
                            'width'  => '150',
                            'height' => '150',
                        )),
                        array('rel' => 'lightbox')
                    );
                ?></td>
                <td valign="baseline" width="60%"><?php
                    $qty_validation = 'max['.$product->quantity_available.']'
                                    .',min['.$product->min_quantity.']';
                    $input_qty =  form_input(array(
                        'id'    => 'quantity',
                        'value' => $product->min_quantity,
                        'class' => 'positive-integer validate[required,'.$qty_validation.']'
                    ));
                    $button_add_cart = button_link(
                        false,
                        lang('add_to_cart'),
                        array(
                            'id' => 'add_to_cart',
                        )
                    );
                    $info_list = array(
                        label(lang('product_code').':').' '.$product->product_code,
                        label(lang('product_availability').':').' '.$product->quantity_available,
                        label(lang('cart_min_quantity_to_add').':').$product->min_quantity,
                        label(lang('product_quantity').':').' '.$input_qty.' '.$button_add_cart,
                    );
                    if($product->is_amulet()) {
                        $amulet_info = label(lang('amulet').': ').anchor(
                            site_url('amulet/'.$product->amulet()->id),
                            $product->amulet()->amulet_name
                        );
                        // insert amulet info in front of array
                        array_unshift($info_list, $amulet_info);
                    }
                    $info_list_attr = array(
                        'class' => 'no-bullet'
                    );
                    echo ul($info_list, $info_list_attr);
                    echo br(1);
                    echo sharable();
                ?></td>
            </tr>
            <tr class="content">
                <td width="40%"><?php
                    $image_list = array();
                    $image_list_attr = array(
                        'class' => 'grid-view'
                    );
                    foreach($product->product_image as $image) {
                        $image_list[$image->id] = anchor(
                            $image->url,
                            img(array(
                                'src'    => $image->url,
                                'alt'    => $image->alt,
                                'width'  => '80',
                                'height' => '80',
                                'title' => $image->image_desc,
                            )),
                            array('rel' => 'lightbox')
                        );
                    }
                    echo ul($image_list, $image_list_attr);
                ?></td>
                <td width="60%"><?php
                    echo label(lang('product_description')).br(1);
                    echo $product->product_desc;
                ?></td>
            </tr>
        </table>
    </form>
</div>
