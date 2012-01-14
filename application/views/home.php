<?php echo clear_div(); ?>
<style type="text/css">
div.product-header {
    color: red;
    font-size: 2em;
}
</style>
<div class="grid_16">
    <div class="slider-wrapper theme-default">
        <div class="ribbon"></div>
        <div id="slider" class="nivoSlider" style="height: 280px;"><?php
            echo anchor(
                site_url('product/view/1'),
                img(array(
                    'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                    'height' => 280,
                ))
            );
            echo anchor(
                site_url('product/view/1'),
                img(array(
                    'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                    'height' => 280,
                ))
            );
            echo anchor(
                site_url('product/view/1'),
                img(array(
                    'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                    'height' => 280,
                    'title'  => '#htmlcaption'
                ))
            );
            echo anchor(
                site_url('product/view/1'),
                img(array(
                    'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                    'height' => 280,
                    'title'  => 'product description'
                ))
            );
        ?>
        </div>
        <div id="htmlcaption" class="nivo-html-caption">
            <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
        </div>
    </div>
<?php echo clear_div(); ?>
<div id="hot-product" class="grid_16">
    <div class="box">
        <div class="box-heading"><?php echo lang('hot'); ?></div>
        <div class="box-content">
            <div class="box-product">
                <div>
                    <div class="image"><?php
                        echo anchor(
                            site_url('product/view/1'),
                            img(array(
                                'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                                'height' => 90,
                                'width'  => 90,
                                'title'  => 'product description'
                            ))
                        );
                    ?></div>
                    <div class="name"><?php
                        echo anchor(
                            site_url('product/view/1'),
                            'TEST'
                        );
                    ?></div>
                    <div class="price"><?php
                        echo 'RM 150.00';
                    ?></div>
                    <div class="cart"><?php
                        echo form_button(array(
                            'id'      => 'add_to_cart_1',
                            'content' => lang('add_to_cart'),
                            'onclick' => 'add_to_cart(1)'
                        ));
                    ?></div>
                </div>
                <div>
                    <div class="image"><?php
                        echo anchor(
                            site_url('product/view/1'),
                            img(array(
                                'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                                'height' => 90,
                                'width'  => 90,
                                'title'  => 'product description'
                            ))
                        );
                    ?></div>
                    <div class="name"><?php
                        echo anchor(
                            site_url('product/view/1'),
                            'TEST'
                        );
                    ?></div>
                    <div class="price"><?php
                        echo 'RM 150.00';
                    ?></div>
                    <div class="cart"><?php
                        echo form_button(array(
                            'id'      => 'add_to_cart_1',
                            'content' => lang('add_to_cart'),
                            'onclick' => 'add_to_cart(1)'
                        ));
                    ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo clear_div(); ?>
<div id="latest-product" class="grid_16">
    <div class="box">
        <div class="box-heading"><?php echo lang('latest'); ?></div>
        <div class="box-content">
            <div class="box-product">
                <div>
                    <div class="image"><?php
                        echo anchor(
                            site_url('product/view/1'),
                            img(array(
                                'src'    => base_url('images/products/1/2eba14f233925924e0767622de106054.jpg'),
                                'height' => 90,
                                'width'  => 90,
                                'title'  => 'product description'
                            ))
                        );
                    ?></div>
                    <div class="name"><?php
                        echo anchor(
                            site_url('product/view/1'),
                            'TEST'
                        );
                    ?></div>
                    <div class="price"><?php
                        echo 'RM 150.00';
                    ?></div>
                    <div class="cart"><?php
                        echo form_button(array(
                            'id'      => 'add_to_cart_1',
                            'content' => lang('add_to_cart'),
                            'onclick' => 'add_to_cart(1)'
                        ));
                    ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo clear_div(); ?>

<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>
