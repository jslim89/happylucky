<script type="text/javascript">
$(document).ready(function() {
    $('#form_step_4').validationEngine('attach');
});
</script>
<div id="account-delivery">
    <div class="checkout-heading"><?php
        echo lang('cart_checkout_step_4');
    ?></div>
    <div class="checkout-content" style="display: block;">
    <?php echo form_open(site_url('order/make'), array('id' => 'form_step_4')); ?>
        <div class="grid_16">
<table width="100%">
    <thead>
        <tr>
            <td class="name"><?php
                echo lang('product_name');
            ?></td>
            <td class="amulet"><?php
                echo lang('amulet');
            ?></td>
            <td class="quantity"><?php
                echo lang('product_quantity');
            ?></td>
            <td class="price"><?php
                echo lang('product_price');
            ?></td>
            <td class="total"><?php
                echo lang('product_total');
            ?></td>
        </tr>
    </thead>
    <tbody>
        <?php
            $total = 0;
            foreach($products as $rowid => $product):
        ?>
        <tr id="cart_row_<?php echo $product->id; ?>">
            <td class="name"><?php 
                echo anchor(
                    site_url('product/view/'.$product->id),
                    $product->product_name
                );
            ?></td>
            <td class="amulet"><?php 
                $amulet = $product->amulet();
                echo anchor(
                    site_url('amulet/view/'.$amulet->id),
                    $amulet->amulet_name
                );
            ?></td>
            <td class="quantity"><?php
                echo $product->qty;
            ?></td>
            <td class="price"><?php
                echo to_currency($product->standard_price);
            ?></td>
            <td class="price"><?php
                echo to_currency($product->subtotal);
                $total += $product->subtotal;
            ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    <tfoot>
        <tr>
            <td class="price" colspan="4"><?php
                echo lang('cart_sub_total');
            ?></td>
            <td class="total"><?php
                echo to_currency($total, 'MYR');
            ?></td>
        </tr>
        <tr>
            <td class="price" colspan="4"><?php
                echo lang('cart_shipping');
            ?></td>
            <td class="total"><?php
                echo to_currency(0, 'MYR');
            ?></td>
        </tr>
        <tr>
            <td class="price" colspan="4"><?php
                echo lang('cart_total');
            ?></td>
            <td class="total"><?php
                echo to_currency($total, 'MYR');
            ?></td>
        </tr>
    </tfoot>
</table>
            <div class="buttons">
                <div class="right"><?php
                    echo button_link(
                        false,
                        lang('cart_confirm_order'),
                        array(
                            'id'      => 'button-continue',
                            'onclick' => '$(\'#form_step_4\').submit();'
                        )
                    );
                ?></div>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
