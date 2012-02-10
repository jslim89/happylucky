<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->lang->load('product');
?>
<div class="box">
    <div class="box-heading"><?php
        echo lang('dashboard_stock_to_be_reload');
    ?></div>
    <div class="box-content">
        <?php if(count($stocks) < 1): ?>
            <div class='success'><?php 
                echo lang('dashboard_no_stock_to_be_reload');
            ?></div>
        <?php else: ?>
            <table id="pending_order_list" class="listing" width="100%">
                <tr class="left">
                    <th width="15%"><?php echo lang('product_code');?></th>
                    <th width="30%"><?php echo lang('product_name');?></th>
                    <th width="20%"><?php echo lang('product_quantity_left');?></th>
                    <th width="35%"><?php echo lang('product_total_number_sold');?></th>
                </tr>
                <?php foreach($stocks as $stock):?>
                <tr>
                    <td><?php
                        echo anchor(
                            site_url('admin/product/edit/'.$stock->id),
                            $stock->product_code
                        );
                    ?></td>
                    <td><?php echo $stock->product_name;?></td>
                    <td><?php echo $stock->quantity_available;?></td>
                    <td><?php echo $stock->total_num_sold;?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
