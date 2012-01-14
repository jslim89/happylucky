<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url);
    });

    $('#verify_link').click(function() {
        $('span#spinner-verify').show();
        $.ajax({
            url: base_url+'user/send_verification_code/<?php echo $customer->id;?>',
            dataType: 'json',
            success: function(data) {
                $('#verification-warning').hide();
                if(data.status == true) {
                    $('#verify-success').show();
                }
                else {
                    $('#verify-failed').show();
                }
            },
            complete: function(jqXHR, textStatus) {
                $('span#spinner-verify').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });

    $('#user_form').validationEngine('attach');
});
</script>
<?php if( ! $customer->is_verified): ?>
<div class="grid_16 notification">
    <div id="verification-warning" class="attention">
        <?php echo lang('user_your_account_has_not_verified').'.'; ?>
        <a class="hand-cursor" id="verify_link"><?php
        echo lang('user_verify');
        ?></a>
        <?php echo ' '.lang('now').' '.spinner('spinner-verify'); ?>
    </div>
    <div id="verify-failed" class="warning" style="display: none;"><?php
        echo lang('error');
    ?></div>
    <div id="verify-success" class="success" style="display: none;"><?php
        echo lang('user_an_email_has_been_sent_to_your_mailbox');
    ?></div>
</div>
<?php
    echo clear_div();
    endif;
?>

<div class="grid_11">
    <div class="box">
        <div class="box-heading"><?php
            echo lang('user_personal_details');
        ?></div>
        <div class="box-content">
            <table width="100%">
                <tr>
                    <td class="right" width="20%"><?php
                        echo label(lang('user_first_name')).': ';
                    ?></td>
                    <td width="30%"><?php
                        echo $customer->first_name;
                    ?></td>
                    <td class="right" width="20%"><?php
                        echo label(lang('user_last_name')).': ';
                    ?></td>
                    <td width="30%"><?php
                        echo $customer->last_name;
                    ?></td>
                </tr>
                <tr>
                    <td class="right"><?php
                        echo label(lang('email')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->email;
                    ?></td>
                    <td class="right"><?php
                        echo label(lang('user_registration_date')).': ';
                    ?></td>
                    <td><?php
                        echo to_human_date_time($customer->registration_date);
                    ?></td>
                </tr>
                <tr>
                    <td class="right"><?php
                        echo label(lang('user_age')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->age ? $customer->age : nbs(1);
                    ?></td>
                    <td class="right"><?php
                        echo label(lang('user_sex')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->sex ? $customer->sex : nbs(1);
                    ?></td>
                </tr>
                <tr>
                    <td class="right"><?php
                        echo label(lang('user_contact_no')).': ';
                    ?></td>
                    <td colspan="3"><?php
                        echo $customer->contact_no;
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="box">
        <div class="box-heading"><?php
            echo lang('address');
        ?></div>
        <div class="box-content">
            <table width="100%">
                <tr>
                    <td class="right" width="20%"><?php
                        echo label(lang('address')).': ';
                    ?></td>
                    <td width="30%"><?php
                        echo $customer->address;
                    ?></td>
                    <td class="right" width="20%"><?php
                        echo label(lang('town')).': ';
                    ?></td>
                    <td width="30%"><?php
                        echo $customer->town ? $customer->town : nbs(1);
                    ?></td>
                </tr>
                <tr>
                    <td class="right"><?php
                        echo label(lang('postcode')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->postcode ? $customer->postcode : nbs(1);
                    ?></td>
                    <td class="right"><?php
                        echo label(lang('city')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->city;
                    ?></td>
                </tr>
                <tr>
                    <td class="right"><?php
                        echo label(lang('state')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->state;
                    ?></td>
                    <td class="right"><?php
                        echo label(lang('country')).': ';
                    ?></td>
                    <td><?php
                        echo $customer->country->country_name;
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="grid_4">
    <div class="box">
        <div class="box-heading"><?php
            echo lang('user_account');
        ?></div>
        <div class="box-content"><?php
            $list = array(
                anchor(
                    site_url('user/edit/'.$customer->id).'?category=personal',
                    lang('user_edit_personal_details')
                ),
                anchor(
                    site_url('user/edit/'.$customer->id).'?category=address',
                    lang('user_edit_address_information')
                ),
                anchor(
                    site_url('user/edit/'.$customer->id).'?category=password',
                    lang('user_change_password')
                ),
            );
            echo ul($list);
        ?></div>
    </div>
</div>
<?php echo clear_div();?>
