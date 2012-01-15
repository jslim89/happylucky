<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#btn_back').click(function() {
        redirect(base_url+'user');
    });

    $('#btn_save').click(function() {
        $('#form_edit_personal').submit();
    });

    $('#form_edit_personal').validationEngine('attach');
});
</script>

<form id="form_edit_personal" method="POST" action="<?php site_url('user/edit').'?category=personal';?>">
    <div class="grid_16">
        <div class="box">
            <div class="box-heading"><?php
                echo lang('user_edit_personal_details');
            ?></div>
            <div class="box-content">
                <table class="form" width="100%">
                    <tr>
                        <td class="right"><?php
                            echo required_indicator().label(lang('user_first_name')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'first_name',
                                'name'  => 'first_name',
                                'value' => $customer->first_name,
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                        <td class="right"><?php
                            echo label(lang('user_sex')).': ';
                        ?></td>
                        <td><?php
                            // By default is male
                            echo form_radio(array(
                                'id'      => Customer_Model::MALE,
                                'name'    => 'sex',
                                'value'   => Customer_Model::MALE,
                                'checked' => ($customer->sex === Customer_Model::MALE),
                            ));
                            echo lang('user_male');
                            echo form_radio(array(
                                'id'      => Customer_Model::FEMALE,
                                'name'    => 'sex',
                                'value'   => Customer_Model::FEMALE,
                                'checked' => ($customer->sex === Customer_Model::FEMALE),
                            ));
                            echo lang('user_female');
                        ?></td>
                    </tr>
                    <tr>
                        <td class="right"><?php
                            echo required_indicator().label(lang('user_last_name')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'last_name',
                                'name'  => 'last_name',
                                'value' => $customer->last_name,
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                        <td class="right"><?php
                            echo label(lang('user_age')).': ';
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'age',
                                'name'  => 'age',
                                'value' => $customer->age,
                                'class' => 'positive-integer',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td class="right"><?php
                            echo required_indicator().label(lang('user_contact_no')).': ';
                        ?></td>
                        <td colspan="3"><?php
                            echo form_input(array(
                                'id'    => 'contact_no',
                                'name'  => 'contact_no',
                                'value' => $customer->contact_no,
                                'class' => 'validate[required]',
                            ));
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
