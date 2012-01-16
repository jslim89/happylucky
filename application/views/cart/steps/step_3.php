<script type="text/javascript">
$(document).ready(function() {
    $('#form_step_3').validationEngine('attach');
});
</script>
<div id="account-delivery">
    <div class="checkout-heading"><?php
        echo lang('cart_checkout_step_3');
    ?></div>
    <div class="checkout-content" style="display: block;">
    <?php echo form_open(site_url('cart/checkout/4'), array('id' => 'form_step_3')); ?>
        <div class="grid_16">
        <?php
            echo form_label(
                form_radio(array(
                    'id'      => 'cod',
                    'name'    => 'payment_method',
                    'value'   => 'cod',
                )).'<b>'.lang('cart_cash_on_delivery').'</b>',
                'cod'
            );
            echo div(lang('cart_cod_hint'), array(
                'class' => 'hint'
            ));
            echo form_label(
                form_radio(array(
                    'id'      => 'bank_in',
                    'name'    => 'payment_method',
                    'checked' => TRUE,
                    'value'   => 'bank_in',
                )).'<b>'.lang('cart_bank_in').'</b>',
                'bank_in'
            );
            echo div(lang('cart_bank_in_hint'), array(
                'class' => 'hint'
            ));
        ?>
            <p><?php echo lang('any')
                .' '.lang('information')
                .' '.lang('please')
                .' '.anchor(
                    site_url('contact_us'),
                    lang('contact_us'),
                    array(
                        'target' => '_blank'
                    )
                );
            ?></p>
        </div>
        <div class="buttons">
            <div class="right"><?php
            echo lang('user_agree_privacy_policy').' ';
            echo anchor(
                site_url('information/terms_and_conditions'),
                lang('terms_and_conditions'),
                'rel=lightbox'
            );
            echo form_checkbox(array(
                'id'    => 'agree',
                'name'  => 'agree',
                'class' => 'validate[required]',
            ));
            echo button_link(
                false,
                lang('continue'),
                array(
                    'id'      => 'button-continue',
                    'onclick' => '$(\'#form_step_3\').submit();'
                )
            );
            ?></div>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
