<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span[id^=view_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            redirect(base_url+'admin/order/view/'+id);
        });
    });
    $('#btn_add_new').click(function() {
        redirect('<?php echo site_url('admin/order/add'); ?>');
    });

    $('#order_status').change(function() {
        var url = base_url+'admin/order.html?status='+$(this).val();
        redirect(url);
    });
});
</script>

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_10 pagination">
    <span class="pagin"><?php
        echo $pagin;
    ?></span>
    <?php
        echo lang('page').nbs(2);
        echo $pagination->create_links().nbs(1);
    ?>
</div>
<!-- End Pagination -->

<!-- Action Button -->
<div class="grid_5">
    <div class="buttons">
        <div class="right"><?php
            echo label(lang('order_status'));
            echo nbs(2);
            echo form_dropdown(
                'order_status',
                Customer_Order_Model::get_dropdown_list(),
                $status_selected,
                'id="order_status"'
            );
            echo nbs(2);
            echo button_link(
                false,
                lang('add_new'),
                array('id' => 'btn_add_new')
            );
        ?></div>
    </div>
</div>
<!-- End Action Button -->
<?php echo clear_div();?>

<div class="grid_16">
    <table class="list">
        <thead>
            <tr>
                <td width="8%" class="<?php if(get_post('order_by') == 'id') echo strtolower($seq_order_id);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=id&seq='.$seq_order_id,
                        lang('order_order_id')
                    );
                ?></td>
                <td class="<?php if(get_post('order_by') == 'first_name') echo strtolower($seq_customer_name);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=first_name&seq='.$seq_customer_name,
                        lang('order_customer_name')
                    );
                ?></td>
                <td class="<?php if(get_post('order_by') == 'order_date') echo strtolower($seq_order_date);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=order_date&seq='.$seq_order_date,
                        lang('order_order_date')
                    );
                ?></td>
                <td class="<?php if(get_post('order_by') == 'subtotal') echo strtolower($seq_subtotal);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=subtotal&seq='.$seq_subtotal,
                        lang('order_subtotal')
                    );
                ?></td>
                <td class="<?php if(get_post('order_by') == 'shipping_cost') echo strtolower($seq_shipping);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=shipping_cost&seq='.$seq_shipping,
                        lang('order_shipping')
                    );
                ?></td>
                <td class="<?php if(get_post('order_by') == 'grand_total') echo strtolower($seq_grand_total);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=grand_total&seq='.$seq_grand_total,
                        lang('order_total')
                    );
                ?></td>
                <td class="<?php if(get_post('order_by') == 'order_status') echo strtolower($seq_status);?>"><?php
                    echo anchor(
                        site_url('admin/order').'?status='.$status_selected.'&order_by=order_status&seq='.$seq_status,
                        lang('order_status')
                    );
                ?></td>
                <td width="5%"><?php echo lang('view');?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order):?>
            <tr id="order_row_<?php echo $order->id; ?>">
                <td><?php 
                    echo anchor(
                        site_url('admin/order/view/'.$order->id),
                        $order->id
                    );
                ?></td>
                <td><?php
                    if($order->is_member_order()) {
                        $name = anchor(
                            site_url('admin/customer/edit/'.$order->customer_id),
                            $order->first_name.", ".$order->last_name
                        );
                    }
                    else {
                        $name = $order->first_name.", ".$order->last_name;
                    }
                    echo $name;
                ?></td>
                <td><?php echo to_human_date($order->order_date); ?></td>
                <td><?php echo to_currency($order->subtotal); ?></td>
                <td><?php echo to_currency($order->shipping); ?></td>
                <td><?php echo to_currency($order->grand_total); ?></td>
                <td><?php echo Customer_Order_Model::status($order->order_status); ?></td>
                <td>
                    <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                        <li class="ui-state-default ui-corner-all">
                            <span id="view_<?php echo $order->id; ?>" class="ui-icon ui-icon-pencil"
                                title="<?php echo lang('edit');?>"></span>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
