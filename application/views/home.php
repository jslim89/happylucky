<?php echo clear_div(); ?>
<style type="text/css">
div.product-header {
    color: red;
    font-size: 2em;
}
</style>
<div class="grid_16">
    <div class="slider-wrapper theme-default">
        <div id="slider" class="nivoSlider" style="height: 280px;"><?php
            foreach($slideshows as $img) {
                echo anchor(
                    site_url('product/view/1'),
                    img(array(
                        'src'    => $img,
                        'height' => 280,
                    ))
                );
            }
        ?></div>
    </div>
<?php echo clear_div(); ?>
<div id="hot-product" class="grid_16">
    <div class="box">
        <div class="box-heading"><?php echo lang('hot'); ?></div>
        <div class="box-content">
        <?php if(sizeof($hot_products) == 0): ?>
        <div class="warning"><?php echo lang('product_no_product'); ?></div>
        <?php else: ?>
            <div class="box-product">
            <?php foreach($hot_products as $product): ?>
                <div>
                    <div class="image"><?php
                        $img = $product->primary_image_url
                            ? $product->primary_image_url
                            : default_image_path();
                        echo anchor(
                            site_url('product/view/'.$product->id),
                            img(array(
                                'src'    => $img,
                                'height' => 90,
                                'width'  => 90,
                                'title'  => $product->product_desc
                            ))
                        );
                    ?></div>
                    <div class="name"><?php
                        echo anchor(
                            site_url('product/view/'.$product->id),
                            $product->product_name
                        );
                    ?></div>
                    <div class="price"><?php
                        echo to_currency($product->standard_price, 'RM');
                    ?></div>
                    <?php
                        $min_qty_to_add = '('.lang('cart_min_quantity_to_add')
                            .': '.$product->min_quantity.')';
                        echo div($min_qty_to_add, array(
                            'class' => 'min_qty_add hint',
                        ));
                        echo div('', array(
                            'id'    => 'add_to_cart_status_'.$product->id,
                            'style' => 'display: none;',
                            'class' => 'warning',
                        ));
                    ?>
                    <div class="cart"><?php
                        echo button_link(
                            false,
                            lang('add_to_cart'),
                            array(
                                'id'      => 'add_to_cart_'.$product->id,
                                'onclick' => 'add_to_cart('.$product->id.', '.$product->min_quantity.')'
                            )
                        );
                    ?></div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php echo clear_div(); ?>
<div id="latest-product" class="grid_16">
    <div class="box">
        <div class="box-heading"><?php echo lang('latest'); ?></div>
        <div class="box-content">
        <?php if(sizeof($latest_products) == 0): ?>
        <div class="warning"><?php echo lang('product_no_product'); ?></div>
        <?php else: ?>
            <div class="box-product">
            <?php foreach($latest_products as $product): ?>
                <div>
                    <div class="image"><?php
                        $img = $product->primary_image_url
                            ? $product->primary_image_url
                            : default_image_path();
                        echo anchor(
                            site_url('product/view/'.$product->id),
                            img(array(
                                'src'    => $img,
                                'height' => 90,
                                'width'  => 90,
                                'title'  => $product->product_desc
                            ))
                        );
                    ?></div>
                    <div class="name"><?php
                        echo anchor(
                            site_url('product/view/'.$product->id),
                            $product->product_name
                        );
                    ?></div>
                    <div class="price"><?php
                        echo to_currency($product->standard_price, 'RM');
                    ?></div>
                    <?php
                        $min_qty_to_add = '('.lang('cart_min_quantity_to_add')
                            .': '.$product->min_quantity.')';
                        echo div($min_qty_to_add, array(
                            'class' => 'min_qty_add hint',
                        ));
                        echo div('', array(
                            'id'    => 'add_to_cart_status_'.$product->id,
                            'style' => 'display: none;',
                            'class' => 'warning',
                        ));
                    ?>
                    <div class="cart"><?php
                        echo button_link(
                            false,
                            lang('add_to_cart'),
                            array(
                                'id'      => 'add_to_cart_'.$product->id,
                                'onclick' => 'add_to_cart('.$product->id.', '.$product->min_quantity.')'
                            )
                        );
                    ?></div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php echo clear_div(); ?>

<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>
