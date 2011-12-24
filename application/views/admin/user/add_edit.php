<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'admin/user');
    });

    $('#user_add_edit').validationEngine({
        ajaxSubmit: true,
        ajaxSubmitFile: base_url+"admin/user/check_email/",
        success: false,
        failure: function() { }
    });
});
/*
"check_email_unique": {
    "url": base_url+"admin/user/check_email/",
    "extraDataDynamic": ['#email'],
    "alertText": 'This email already been used.',
    "alertTextOk": '',
    "alertTextLoad": 'Validating...',
}
*/
</script>

<div id="general">
    <form id="user_add_edit" method="POST" 
          action="<?php echo site_url("admin/user/save/".$user->id);?>">
        <table>
            <tr>
                <td class="label"><?php echo lang('user_first_name');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'first_name',
                            'id'    => 'first_name',
                            'value' => $user->first_name,
                            'class' => 'validate[required] text'
                        ));
                    ?>
                </td>
                <td class="label"><?php echo lang('user_last_name');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'last_name',
                            'id'    => 'last_name',
                            'value' => $user->last_name,
                            'class' => 'validate[required] text'
                        ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang('email');?></td>
                <td colspan="<?php $user->is_exist() ? 3 : 1;?>">
                    <?php 
                        if($user->is_exist()) { // Email cannot be change
                            echo "<span>"
                                .$user->email
                                ."</span>";
                        }
                        else {
                            echo form_input(array(
                                'name'  => 'email',
                                'id'    => 'email',
                                'value' => $user->email,
                                'class' => 'validate[required,custom[email,ajax[check_email_unique]]]'
                            ));
                        }
                    ?>
                </td>
                <?php if( ! $user->is_exist()): ?>
                <td><?php echo lang('user_password');?></td>
                <td><?php 
                    echo form_password(array(
                        'name'  => 'password',
                        'id'    => 'password',
                        'value' => '',
                        'class' => 'validate[required,minSize[8]]'
                    ));
                ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <td><?php echo lang('user_security_question');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'security_question',
                            'id'    => 'security_question',
                            'value' => $user->security_question,
                            'class' => ''
                        ));
                    ?>
                </td>
                <td><?php echo lang('user_security_answer');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'security_answer',
                            'id'    => 'security_answer',
                            'value' => $user->security_answer,
                            'class' => ''
                        ));
                    ?>
                </td>
            </tr>
        </table>
        <div class="right">
            <?php
                echo form_button(array(
                    'id'      => 'back',
                    'content' => lang('back'),
                ));
                echo form_submit('save_user', lang('save'), 'class="button"');
            ?>
        </div>
    </form>
</div>
