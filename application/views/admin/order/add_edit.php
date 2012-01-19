<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#back').click(function() {
        redirect(base_url+'admin/order');
    });

    $('#save_order_add_edit').click(function() {
        $('#order_add_edit').submit();
    });

    $('#order_add_edit').validationEngine('attach');
});

</script>

<div id="general">
    <form id="order_add_edit" method="POST" 
          action="<?php echo site_url("admin/order/save/".$order->id);?>">
        <table class="form">
            <tr>
                <td class="label"><?php echo lang('order_first_name');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'first_name',
                            'id'    => 'first_name',
                            'value' => $order->first_name,
                            'class' => 'validate[required] text'
                        ));
                    ?>
                </td>
                <td class="label"><?php echo lang('order_last_name');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'last_name',
                            'id'    => 'last_name',
                            'value' => $order->last_name,
                            'class' => 'validate[required] text'
                        ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang('email');?></td>
                <td colspan="<?php $order->is_exist() ? 3 : 1;?>">
                    <?php 
                        if($order->is_exist()) { // Email cannot be change
                            echo "<span>"
                                .$order->email
                                ."</span>";
                        }
                        else {
                            echo form_input(array(
                                'name'  => 'email',
                                'id'    => 'email',
                                'value' => $order->email,
                                'class' => 'validate[required,custom[email,ajax[ajaxUserEmail]]]'
                            ));
                        }
                    ?>
                </td>
                <?php if( ! $order->is_exist()): ?>
                <td><?php echo lang('order_password');?></td>
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
                <td><?php echo lang('order_security_question');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'security_question',
                            'id'    => 'security_question',
                            'value' => $order->security_question,
                            'class' => ''
                        ));
                    ?>
                </td>
                <td><?php echo lang('order_security_answer');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'security_answer',
                            'id'    => 'security_answer',
                            'value' => $order->security_answer,
                            'class' => ''
                        ));
                    ?>
                </td>
            </tr>
        </table>
        <div class="buttons">
            <div class="right"><?php
                echo button_link(
                    false,
                    lang('back'),
                    array('id' => 'back')
                );
                echo nbs(2);
                echo button_link(
                    false,
                    lang('save'),
                    array('id' => 'save_order_add_edit')
                );
            ?></div>
        </div>
    </form>
</div>
