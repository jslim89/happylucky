<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('div.security-qa').hide();
    $('#form_forgot_password').validationEngine('attach');
    $('#btn_check_email').click(function() {
        $('span#spinner-email').show();
        $.ajax({
            url: base_url+'user/get_security_question/',
            data: 'email='+$('#email').val(),
            dataType: 'json',
            success: function(data) {
                if(data.status == 1) {
                    $('span#question').text(data.security_question);
                    $('div.security-qa').show(2000);
                    $('#invalid-email').hide(2000);
                }
                else {
                    $('#invalid-email')
                        .text('<?php echo lang('user_invalid_email');?>')
                        .show(2000);
                }
            },
            complete: function(jqXHR, textStatus) {
                $('span#spinner-email').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
    $('#btn_check_answer').click(function() {
        var email = $('#email').val();
        var answer = $('#security_answer').val();
        $('span#spinner-answer').show();
        $.ajax({
            url: base_url+'user/check_security_answer/',
            data: 'email='+email+'&answer='+answer,
            dataType: 'json',
            success: function(data) {
                $('#answer-response').text(data.response_text)
                if(data.status == true) {
                    $('#answer-response')
                        .addClass('success')
                        .removeClass('warning');
                }
                else {
                    $('#answer-response')
                        .addClass('warning')
                        .removeClass('success');
                }
            },
            complete: function(jqXHR, textStatus) {
                $('span#spinner-answer').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
});
</script>
</div>
<?php echo clear_div();?>

<form id="form_forgot_password" method="POST" action="<?php echo site_url('user/forgot_password');?>">
    <div class="login-content">
        <div class="left grid_16">
            <?php echo heading(lang('user_forgot_password'), 2); ?>
            <div class="content">
                <p><?php echo lang('user_forgot_password_guideline'); ?></p>
                <?php 
                    echo label(lang('email'));
                    echo br(1);
                    echo form_input(array(
                        'id'    => 'email',
                        'name'  => 'email',
                        'class' => 'validate[required,custom[email]]',
                    ));
                    echo spinner('spinner-email');
                    echo nbs(2);
                    echo button_link(
                        false,
                        lang('check'),
                        array('id' => 'btn_check_email')
                    );
                    echo br(1);
                ?>
                <div class="warning" style="display:none;" id="invalid-email"></div>
                <div class="security-qa"><?php
                    echo br(2);
                    echo label(lang('user_security_question'));
                    echo ': <span id="question"></span>';
                    echo br(2);
                    echo label(lang('user_security_answer'));
                    echo br(1);
                    echo form_input(array(
                        'id'    => 'security_answer',
                        'name'  => 'security_answer',
                    ));
                    echo spinner('spinner-answer');
                    echo nbs(2);
                    echo button_link(
                        false,
                        lang('check'),
                        array('id' => 'btn_check_answer')
                    );
                    echo br(1);
                ?>
                </div>
                <div id="answer-response"></div>
            </div>
        </div>
    </div>
</form>
