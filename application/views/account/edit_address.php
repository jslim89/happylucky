<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#btn_back').click(function() {
        redirect(base_url+'user');
    });

    $('#btn_save').click(function() {
        $('#form_edit_address').submit();
    });

    $('#form_edit_address').validationEngine('attach');
});
</script>

<form id="form_edit_address" method="POST" action="<?php site_url('user/edit').'?category=address';?>">
    <div class="grid_16">
        <div class="box">
            <div class="box-heading"><?php
                echo lang('user_edit_address_information');
            ?></div>
            <div class="box-content">
                <table class="form" width="100%">
                    <tr>
                        <td class="right"><?php
                            echo required_indicator().label(lang('address')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'address',
                                'name'  => 'address',
                                'value' => $customer->address,
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                        <td class="right"><?php
                            echo label(lang('town')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'town',
                                'name'  => 'town',
                                'value' => $customer->town,
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td class="right"><?php
                            echo label(lang('postcode')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'postcode',
                                'name'  => 'postcode',
                                'value' => $customer->postcode,
                            ));
                        ?></td>
                        <td class="right"><?php
                            echo required_indicator().label(lang('city')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'city',
                                'name'  => 'city',
                                'value' => $customer->city,
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td class="right"><?php
                            echo required_indicator().label(lang('state')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'state',
                                'name'  => 'state',
                                'value' => $customer->state,
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                        <td class="right"><?php
                            echo required_indicator().label(lang('country')).': ';
                        ?></td>
                        <td><?php
                            echo form_dropdown(
                                'country_id',
                                Country_Model::get_dropdown_list(),
                                $customer->country_id
                            );
                        ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="buttons">
            <div class="left"><?php
                echo button_link(
                    false,
                    lang('save'),
                    array('id' => 'btn_save')
                );
            ?></div>
            <div class="right"><?php
                echo button_link(
                    false,
                    lang('back'),
                    array('id' => 'btn_back')
                );
            ?></div>
        </div>
    </div>
    <?php echo clear_div();?>
</form>
