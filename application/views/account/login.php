<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#form_login').validationEngine('attach');
    $('#btn_signin').click(function() {
        $('#form_login').submit();
    });
});
</script>
</div>
<?php echo clear_div();?>

    <form id="form_login" method="POST" action="<?php echo site_url('user/login');?>">
        <div class="login-content">
            <div class="left grid_8">
                <?php echo heading(lang('user_new_customer'), 2); ?>
                <div class="content">
                    <p><?php echo lang('user_register_account'); ?></p>
                    <p><?php echo lang('user_create_account_reason'); ?></p>
                    <?php echo button_link(
                        site_url('user/register'),
                        lang('user_register')
                    );?>
                </div>
            </div>
            <div class="left grid_8">
                <?php echo heading(lang('user_existing_customer'), 2); ?>
                <div class="content"><?php
                    echo label(lang('email'));
                    echo br(1);
                    echo form_input(array(
                        'id'    => 'email',
                        'name'  => 'email',
                        'class' => 'validate[required,custom[email]]',
                    ));
                    echo br(1);
                    echo label(lang('user_password'));
                    echo br(1);
                    echo form_password(array(
                        'id'    => 'password',
                        'name'  => 'password',
                        'class' => 'validate[required]',
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
                        array('id' => 'btn_signin')
                    );
                ?></div>
            </div>
        </div>
    </form>
