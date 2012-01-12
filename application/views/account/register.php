<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#form_register').validationEngine('attach');
});
</script>

<?php echo clear_div();?>

<div class="grid_16">
    <form id="form_register" method="POST" action="<?php echo site_url('user/register');?>">
        <?php echo heading(lang('user_personal_details'), 2); ?>
        <div class="content">
            <table class="form" width="100%">
                <tbody>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_first_name'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'first_name',
                                'name'  => 'first_name',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_last_name'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'last_name',
                                'name'  => 'last_name',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('email'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'email',
                                'name'  => 'email',
                                'class' => 'validate[required,custom[email]]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_contact_no'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'contact_no',
                                'name'  => 'contact_no',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo label(lang('user_age'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'age',
                                'name'  => 'age',
                                'class' => 'positive-integer',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo label(lang('user_sex'));
                        ?></td>
                        <td><?php
                            // By default is male
                            echo form_radio(array(
                                'id'      => Customer_Model::MALE,
                                'name'    => 'sex',
                                'value'   => Customer_Model::MALE,
                                'checked' => TRUE,
                            ));
                            echo lang('user_male');
                            echo form_radio(array(
                                'id'      => Customer_Model::FEMALE,
                                'name'    => 'sex',
                                'value'   => Customer_Model::FEMALE,
                            ));
                            echo lang('user_female');
                        ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php echo heading(lang('user_address_information'), 2); ?>
        <div class="content">
            <table class="form" width="100%">
                <tbody>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('address'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'address',
                                'name'  => 'address',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo label(lang('town'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'town',
                                'name'  => 'town',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo label(lang('postcode'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'postcode',
                                'name'  => 'postcode',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('city'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'city',
                                'name'  => 'city',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('state'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'state',
                                'name'  => 'state',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('country'));
                        ?></td>
                        <td><?php
                            echo form_dropdown(
                                'country_id',
                                Country_Model::get_dropdown_list(),
                                129 // Default is Malaysia
                            );
                        ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php echo heading(lang('user_account'), 2); ?>
        <div class="content">
            <table class="form" width="100%">
                <tbody>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_password'));
                        ?></td>
                        <td><?php
                            echo form_password(array(
                                'id'    => 'passwrod',
                                'name'  => 'passwrod',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_confirm_password'));
                        ?></td>
                        <td><?php
                            echo form_password(array(
                                'id'    => 'confirm_password',
                                'name'  => 'confirm_password',
                                'class' => 'validate[required,equals[password]]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_security_question'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'security_question',
                                'name'  => 'security_question',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo required_indicator();
                            echo label(lang('user_security_answer'));
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'security_answer',
                                'name'  => 'security_answer',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <div class="right"><?php
                echo lang('user_agree_privacy_policy').' ';
                echo anchor(
                    site_url('information/privacy_policy'),
                    lang('privacy_policy'),
                    'rel=lightbox'
                );
                echo form_checkbox(array(
                    'id' => 'agree',
                    'name' => 'agree',
                    'class' => 'validate[required]',
                ));
                echo button_link(
                    false,
                    lang('continue'),
                    array('onclick' => '$(\'#form_register\').submit();')
                );
            ?></div>
        </div>
    </form>
</div>
