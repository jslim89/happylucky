<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span[id^=edit_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            redirect('order/edit/'+id);
        });
    });
    $('#btn_add_new').click(function() {
        redirect('<?php echo site_url('admin/order/add'); ?>');
    });

    /*
    $('span#advanced_search').click(function() {
    });
     */
});
</script>

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_10">
    <?php echo $pagination->create_links().nbs(1);?>
</div>
<!-- End Pagination -->

<!-- Action Button -->
<div class="grid_5 right"><?php
    echo button_link(
        false,
        lang('add_new'),
        array('id' => 'btn_add_new')
    );
?></div>
<!-- End Action Button -->
<?php echo clear_div();?>

<div class="grid_16">
    <table class="list">
        <thead>
            <tr>
                <td width="8%"><?php echo lang('order_order_id');?></td>
                <td><?php echo lang('order_customer_name');?></td>
                <td><?php echo lang('order_order_date');?></td>
                <td><?php echo lang('order_subtotal');?></td>
                <td><?php echo lang('order_shipping');?></td>
                <td><?php echo lang('order_total');?></td>
                <td><?php echo lang('order_status');?></td>
                <td width="5%"><?php echo lang('edit');?></td>
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
                            <span id="edit_<?php echo $order->id; ?>" class="ui-icon ui-icon-pencil"
                                title="<?php echo lang('edit');?>"></span>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
