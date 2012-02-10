<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo clear_div();?>

<?php if( ! get_session('customer_id')): ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#btn_search_order').click(function() {
            var id = $('#order_id').val();
            $('#form_search_order').attr('action', base_url+'order/view/'+id);
            $('#form_search_order').submit();
        });
        $('#form_search_order').validationEngine('attach');
    });
    </script>

    <?php
    $error_msg = $this->session->flashdata('search_order_error');
    if($error_msg):
    ?>
        <div class="grid_16">
            <div class="warning"><?php
                echo $error_msg;
            ?></div>
        </div>
    <?php
        echo clear_div();
        endif;
    ?>

    <form id="form_search_order" method="POST">
        <div class="grid_16">
            <div class="box">
                <div class="box-heading"><?php
                    echo lang('search').' '.lang('for').' '.lang('order');
                ?></div>
                <div class="box-content">
                    <table class="form" width="100%">
                        <tr>
                            <td><?php
                                echo lang('order_enter_your_order_id_and_search').': ';
                            ?></td>
                            <td><?php
                                echo form_input(array(
                                    'id'    => 'order_id',
                                    'class' => 'validate[required]',
                                ));
                            ?></td>
                        </tr>
                        <tr>
                            <td><?php
                                echo lang('email').': ';
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
                            <td colspan="2"><?php
                                    echo span(
                                        lang('order_please_include_your_email_address_in_order_for_us_to_verify').'.',
                                        array('class' => 'hint')
                                    );
                            ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="buttons">
                <div class="right"><?php
                    echo button_link(
                        false,
                        lang('search'),
                        array('id' => 'btn_search_order')
                    );
                ?></div>
            </div>
        </div>
    </form>
<?php else: ?>
    <!-- Pagination -->
    <div class="grid_16 pagination">
        <span class="pagin"><?php
            echo $pagin;
        ?></span>
        <?php
            echo lang('page').nbs(2);
            echo $pagination->create_links().nbs(1);
        ?>
    </div>
    <!-- End Pagination -->

    <?php echo clear_div();?>

    <div class="grid_16">
        <?php if(sizeof($orders) == 0): ?>
            <div class="warning"><?php echo lang('order_no_order_history'); ?></div>
        <?php else: ?>
            <ul class="no-bullet order">
            <?php foreach($orders as $order): ?>
            <li>
                <table width="100%" id="order_list_<?php echo $order->id; ?>">
                    <tr>
                        <td width="40%"><?php 
                            echo label(lang('order_order_id')).': ';
                            $order_url = site_url('order/view/'.$order->id);
                            echo anchor(
                                $order_url,
                                '#'.$order->id
                            );
                        ?></td>
                        <td colspan="2" class="left"><?php
                            echo label(lang('order_status')).': ';
                            echo Customer_Order_Model::status($order->order_status);
                        ?></td>
                    </tr>
                    <tr>
                        <td width="40%"><?php 
                            echo label(lang('order_order_date')).': ';
                            echo to_human_date_time($order->order_date);
                        ?></td>
                        <td width="40%"><?php 
                            echo label(lang('order_customer_name')).': ';
                            echo $order->first_name.', '.$order->last_name;
                        ?></td>
                        <td width="20%" rowspan="2" class="right"><?php 
                            echo button_link(
                                site_url('order/view/'.$order->id),
                                lang('view')
                            );
                        ?></td>
                    </tr>
                    <tr>
                        <td width="40%"><?php 
                            echo label(lang('order_total_products')).': ';
                            echo sizeof($order->order_detail);
                        ?></td>
                        <td colspan="2" width="*"><?php 
                            echo label(lang('order_total')).': ';
                            echo to_currency($order->grand_total, 'MYR');
                        ?></td>
                    </tr>
                </table>
            </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>
