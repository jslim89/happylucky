<script type="text/javascript">
$(document).ready(function() {
    $('#form_step_2').validationEngine('attach');
});
</script>
<div id="account-delivery">
    <div class="checkout-heading"><?php
        echo lang('cart_checkout_step_2');
    ?></div>
    <div class="checkout-content" style="display: block;">
    <?php echo form_open(site_url('cart/checkout/3'), array('id' => 'form_step_2')); ?>
        <div class="left"><?php
            echo heading(lang('cart_personal_details'), 2);
            echo required_indicator().label(lang('user_first_name'));
            echo br(1);
            echo form_input(array(
                'id'    => 'first_name',
                'name'  => 'first_name',
                'class' => 'validate[required]',
            ));
            echo br(1);
            echo required_indicator().label(lang('user_last_name'));
            echo br(1);
            echo form_input(array(
                'id'    => 'last_name',
                'name'  => 'last_name',
                'class' => 'validate[required]',
            ));
            echo br(1);
            echo required_indicator().label(lang('email'));
            echo br(1);
            echo form_input(array(
                'id'    => 'email',
                'name'  => 'email',
                'class' => 'validate[required]',
            ));
            echo br(1);
            echo required_indicator().label(lang('user_contact_no'));
            echo br(1);
            echo form_input(array(
                'id'    => 'shipping_contact_no',
                'name'  => 'shipping_contact_no',
                'class' => 'validate[required]',
            ));
        ?></div>
        <div id="login" class="left"><?php
            echo heading(lang('cart_shipping_address'), 2);
            echo required_indicator().label(lang('address'));
            echo br(1);
            echo form_input(array(
                'id'    => 'shipping_address',
                'name'  => 'shipping_address',
                'class' => 'validate[required]',
            ));
            echo br(1);
            echo label(lang('town'));
            echo br(1);
            echo form_input(array(
                'id'   => 'shipping_town',
                'name' => 'shipping_town',
            ));
            echo br(1);
            echo label(lang('postcode'));
            echo br(1);
            echo form_input(array(
                'id'   => 'shipping_postcode',
                'name' => 'shipping_postcode',
            ));
            echo br(1);
            echo required_indicator().label(lang('city'));
            echo br(1);
            echo form_input(array(
                'id'    => 'shipping_city',
                'name'  => 'shipping_city',
                'class' => 'validate[required]',
            ));
            echo br(1);
            echo required_indicator().label(lang('state'));
            echo br(1);
            echo form_input(array(
                'id'    => 'shipping_state',
                'name'  => 'shipping_state',
                'class' => 'validate[required]',
            ));
            echo br(1);
            echo required_indicator().label(lang('country'));
            echo br(1);
            echo form_dropdown(
                'shipping_country_id',
                Country_Model::get_dropdown_list(),
                129, // default is malaysia
                'id="shipping_country_id"'
            );
        ?></div>
        <?php echo form_close(); ?>
        <div class="buttons">
            <div class="right"><?php
            echo button_link(
                false,
                lang('continue'),
                array(
                    'id' => 'button-continue',
                    'onclick' => '$(\'#form_step_2\').submit();'
                )
            );
            ?></div>
        </div>
    </div>
</div>
