<script type="text/javascript">
$(document).ready(function() {
    $('#button-account').click(function() {
        opt = $('input[name=account]:checked').val();
        redirect(base_url+'cart/checkout.html?opt='+opt);
    });
});
</script>
<div id="checkout">
    <div class="checkout-heading"><?php
        echo lang('cart_checkout_step_1');
    ?></div>
    <div class="checkout-content" style="display: block;">
        <div class="left"><?php
            echo heading(lang('cart_new_customer'), 2);
            echo '<p>'.lang('cart_checkout_options').':</p>';
            echo form_label(
                form_radio(array(
                    'id'      => 'register',
                    'name'    => 'account',
                    'checked' => TRUE,
                    'value'   => 'register',
                )).'<b>'.lang('cart_register_account').'</b>',
                'register'
            );
            echo br(1);
            echo form_label(
                form_radio(array(
                    'id'      => 'guest',
                    'name'    => 'account',
                    'value'   => 'guest',
                )).'<b>'.lang('cart_guest_checkout').'</b>',
                'guest'
            );
            echo br(2);
            echo '<p>'.lang('user_create_account_reason').'</p>';
            echo button_link(
                false,
                lang('continue'),
                array(
                    'id' => 'button-account',
                )
            );
        ?></div>
        <div id="login" class="left"><?php
            echo form_open(site_url('user/login'), array('id' => 'sign-in-form'));
            echo heading(lang('user_signin'), 2);
            echo '<p>'.lang('cart_checkout_options').':</p>';
            echo form_label(lang('email'));
            echo br(1);
            echo form_input(array(
                'id'   => 'email',
                'name' => 'email',
            ));
            echo br(1);
            echo form_label(lang('user_password'));
            echo br(1);
            echo form_password(array(
                'id'   => 'password',
                'name' => 'password',
            ));
            echo br(1);
            echo anchor(
                site_url('user/forgot_password'),
                lang('user_forgot_password')
            );
            echo br(2);
            echo button_link(
                false,
                lang('user_signin'),
                array(
                    'id' => 'btn-login',
                    'onclick' => '$(\'#sign-in-form\').submit();',
                )
            );
            echo form_close();
        ?></div>
    </div>
</div>
