<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#back').click(function() {
        redirect(base_url+'admin/customer');
    });

    $('#save_customer_add_edit').click(function() {
        /*
        if($('#password').val() != '') {
            $('#old_password').addClass('validate[required]');
            $('#confirm_password').addClass('validate[required,equals[password]]');
            $('#password').addClass('validate[required]');
        }
        else {
            $('#old_password').removeClass('validate[required]');
            $('#confirm_password').removeClass('validate[required,equals[password]]');
            $('#password').removeClass('validate[required]');
        }
         */
        $('#customer_add_edit').submit();
    });

    $('#customer_add_edit').validationEngine('attach');

    // Override the original paging link,
    // set the default tab to product orders
    $('div.inner_paging a').each(function() {
        var url = $(this).attr('href');
        $(this).attr('href', url+'.html?tab=1');
    });


    var is_add_new = <?php echo empty($customer->id) ? 'true' : 'false'; ?>;
    var tabs_disable = (is_add_new) ? [1] : [];
    var tabs_selected = (query_string('tab') == null) ? 0 : query_string('tab');
    $('#tabs').tabs({
        disabled: tabs_disable,
        selected: tabs_selected,
        ajaxOptions: {
            error: function(xhr, status, index, anchor) {
                $(anchor.hash).html(
                    "Tab broken"
                );
            }
        }
    });
});

</script>

<div id="tabs">
    <ul>
        <li><a href="#general"><?php echo lang('general'); ?></a></li>
        <li>
            <a href="#orders">
                <?php echo lang('orders'); ?>
            </a>
        </li>
    </ul>
    <div id="general">
        <form id="customer_add_edit" method="POST" 
              action="<?php echo site_url("admin/customer/save/".$customer->id);?>">
            <div class="box grid_7">
                <div class="box-heading"><?php
                    echo lang('user_personal_details');
                ?></div>
                <div class="box-content">
                    <table class="form">
                        <tr>
                            <td class="label"><?php echo required_indicator().lang('user_first_name');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'first_name',
                                    'id'    => 'first_name',
                                    'value' => $customer->first_name,
                                    'class' => 'validate[required] text'
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo required_indicator().lang('user_last_name');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'last_name',
                                    'id'    => 'last_name',
                                    'value' => $customer->last_name,
                                    'class' => 'validate[required] text'
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo required_indicator().lang('email');?></td>
                            <td colspan="<?php $customer->is_exist() ? 3 : 1;?>"><?php 
                                if($customer->is_exist()) { // Email cannot be change
                                    echo "<span>"
                                        .$customer->email
                                        ."</span>";
                                }
                                else {
                                    echo form_input(array(
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'value' => $customer->email,
                                        'class' => 'validate[required,custom[email,ajax[ajaxUserEmail]]]'
                                    ));
                                }
                            ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo required_indicator().lang('user_contact_no');?></td>
                            <td><?php 
                                    echo form_input(array(
                                        'name'  => 'contact_no',
                                        'id'    => 'contact_no',
                                        'value' => $customer->contact_no,
                                        'class' => 'validate[required] text'
                                    ));
                            ?></td>
                        </tr>
                        <?php if($customer->is_exist()): ?>
                        <tr>
                            <td class="label"><?php echo lang('user_member_since');?></td>
                            <td><?php 
                                echo to_human_date_time($customer->registration_date);
                            ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <!--div class="box grid_7">
                <div class="box-heading"><?php
                    echo lang('user_security');
                ?></div>
                <div class="box-content">
                    <table class="form">
                        <?php if($customer->is_exist()): ?>
                        <tr>
                            <td class="label"><?php echo lang('user_old_password');?></td>
                            <td><?php 
                                echo form_password(array(
                                    'id'    => 'old_password',
                                    'name'  => 'old_password',
                                ));
                            ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="label"><?php echo lang('user_password');?></td>
                            <td><?php 
                                echo form_password(array(
                                    'name'  => 'password',
                                    'id'    => 'password',
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo lang('user_confirm_password');?></td>
                            <td><?php 
                                echo form_password(array(
                                    'name'  => 'confirm_password',
                                    'id'    => 'confirm_password',
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo required_indicator().lang('user_security_question');?></td>
                            <td colspan="<?php $customer->is_exist() ? 3 : 1;?>"><?php 
                                echo form_input(array(
                                    'name'  => 'security_question',
                                    'id'    => 'security_question',
                                    'value' => $customer->security_question,
                                    'class' => 'validate[required]'
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo required_indicator().lang('user_security_answer');?></td>
                            <td><?php 
                                    echo form_input(array(
                                        'name'  => 'security_answer',
                                        'id'    => 'security_answer',
                                        'value' => $customer->security_answer,
                                        'class' => 'validate[required] text'
                                    ));
                            ?></td>
                        </tr>
                    </table>
                </div>
            </div-->
            <div class="box grid_7">
                <div class="box-heading"><?php
                    echo lang('user_address_information');
                ?></div>
                <div class="box-content">
                    <table class="form">
                        <tr>
                            <td><?php echo required_indicator().lang('address');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'address',
                                    'id'    => 'address',
                                    'value' => $customer->address,
                                    'class' => 'validate[required]'
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('town');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'town',
                                    'id'    => 'town',
                                    'value' => $customer->town,
                                    'class' => ''
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('postcode');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'postcode',
                                    'id'    => 'postcode',
                                    'value' => $customer->postcode,
                                    'class' => ''
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo required_indicator().lang('city');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'city',
                                    'id'    => 'city',
                                    'value' => $customer->city,
                                    'class' => 'validate[required]'
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo required_indicator().lang('state');?></td>
                            <td><?php 
                                echo form_input(array(
                                    'name'  => 'state',
                                    'id'    => 'state',
                                    'value' => $customer->state,
                                    'class' => 'validate[required]'
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php echo required_indicator().lang('country');?></td>
                            <td>
                                <?php 
                                    $country_selected = (sizeof($customer->country) < 1)
                                        ? 129 // Default is Malaysia
                                        : $customer->country_id;
                                    echo form_dropdown(
                                        'country_id',
                                        Country_Model::get_dropdown_list(),
                                        $country_selected
                                    );
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php echo clear_div(); ?>
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
                        array('id' => 'save_customer_add_edit')
                    );
                ?></div>
            </div>
        </form>
    </div>
    <div id="orders">
    <!-- Display only if the action is EDIT -->
    <?php if($customer->is_exist()): ?>
        <!-- Pagination -->
        <div class="pagination inner_paging">
            <span class="pagin"><?php
                echo $pagin;
            ?></span>
            <?php
                echo lang('page').nbs(2);
                echo $pagination->create_links().nbs(1);
            ?>
        </div>
        <!-- End Pagination -->
        <table class="list">
            <thead>
                <tr>
                    <td><?php echo lang('order_order_id');?></td>
                    <td><?php echo lang('order_order_date');?></td>
                    <td><?php echo lang('order_status');?></td>
                    <td><?php echo lang('order_total');?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order):?>
                <tr id="order_row_<?php echo $order->id; ?>">
                    <td><?php 
                        echo anchor(
                            site_url('admin/order/edit/'.$order->id),
                            $order->id
                        );
                    ?></td>
                    <td><?php echo to_human_date_time($order->order_date);?></td>
                    <td><?php echo $order->order_status;?></td>
                    <td><?php echo to_currency($order->grand_total);?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
</div>
