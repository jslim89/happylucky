<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#btn_back').click(function() {
        redirect(base_url+'user');
    });

    $('#btn_save').click(function() {
        $('#form_edit_password').submit();
    });

    $('#form_edit_password').validationEngine('attach');
});
</script>

<form id="form_edit_password" method="POST" action="<?php site_url('user/edit').'?category=password';?>">
    <div class="grid_16">
        <div class="box">
            <div class="box-heading"><?php
                echo lang('user_change_password');
            ?></div>
            <div class="box-content">
                <table class="form" width="100%">
                    <tr>
                        <td class="right" width="30%"><?php
                            echo label(lang('user_old_password')).': ';
                        ?></td>
                        <td width="*"><?php
                            echo form_password(array(
                                'id'    => 'edit_old_password',
                                'name'  => 'old_password',
                                'class' => 'validate[required,ajax[ajaxCustomerOldPassword]]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td class="right" width="30%"><?php
                            echo label(lang('user_password')).': ';
                        ?></td>
                        <td width="*"><?php
                            echo form_password(array(
                                'id'    => 'edit_password',
                                'name'  => 'password',
                                'class' => 'validate[required]',
                            ));
                        ?></td>
                    </tr>
                    <tr>
                        <td class="right" width="30%"><?php
                            echo label(lang('user_confirm_password')).': ';
                        ?></td>
                        <td width="*"><?php
                            echo form_password(array(
                                'id'    => 'edit_confirm_password',
                                'name'  => 'confirm_password',
                                'class' => 'validate[required,equals[edit_password]]',
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
