<script type="text/javascript">
$(document).ready(function() {
    $('#form_step_3').validationEngine('attach');

    $('input[name=payment_method]').change(function() {
        if($('#cod').is(':checked')) {
            $('#bank-acc').hide(2000);
            $('input#recipient_bank_acc').removeClass('validate[required]');
        }
        else {
            $('#bank-acc').show(2000);
            $('input#recipient_bank_acc').addClass('validate[required]');
        }
    });
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
                    'value'   => Customer_Order_Model::CASH_ON_DELIVERY,
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
                    'value'   => Customer_Order_Model::BANK_IN,
                )).'<b>'.lang('cart_bank_in').'</b>',
                'bank_in'
            );
        ?>
        <div id="bank-acc"><?php
            echo lang('cart_bank_in').' '.lang('to').' Public Bank <br />'
            .lang('cart_name').': '.label('Happy Lucky').'<br />'
            .lang('cart_bank_account_no').': '.label('4-1234567-01').'<br />'
            .lang('contact').': '.label('012-3456789');
            echo div(lang('cart_bank_in_hint'), array(
                'class' => 'hint'
            ));
        ?></div>
            <p><?php echo lang('any')
                .' '.lang('information')
                .' '.lang('please')
                .' '.anchor(
                    site_url('information/contact_us'),
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
