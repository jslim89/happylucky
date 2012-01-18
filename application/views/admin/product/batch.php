<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('#save_batch').click(function() {
        $('#form_batch').submit();
    });
    $('#form_batch').validationEngine('attach');

    $('input#supplier').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/supplier/ajax_search',
        focus: function(event, ui) {
            $(this).val(ui.item.supplier_name);
            return false;
        },
        select: function(event, ui) {
            $(this).val(ui.item.supplier_name);
            $('input[name=supplier_id]').val(ui.item.id);
            return false;
        },
        open: function() {
            $(this).removeClass('ui-corner-all').addClass('ui-corner-top');
        },
        close: function() {
            $(this).removeClass('ui-corner-top').addClass('ui-corner-all');
        }
    })
    .data('autocomplete')._renderItem = function(ul, item){
        return $('<li></li>')
                .data('item.autocomplete', item)
                .append('<a>' + item.supplier_name + '</a>')
                .appendTo(ul);
    };
});
</script>

<div class="box">
    <div class="box-heading"><?php
        echo lang('history');
    ?></div>
    <div class="box-content">
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td><?php
                        echo lang('product_batch_no');
                    ?></td>
                    <td><?php
                        echo lang('product_stock_in_date');
                    ?></td>
                    <td><?php
                        echo lang('product_quantity_stock_in');
                    ?></td>
                    <td><?php
                        echo lang('product_unit_cost');
                    ?></td>
                    <td><?php
                        echo lang('product_from_supplier');
                    ?></td>
                </tr>
            </thead>
            <tbody>
            <?php foreach($product->product_batch as $batch): ?>
                <tr>
                    <td><?php
                        echo $batch->batch_no;
                    ?></td>
                    <td><?php
                        echo to_human_date_time($batch->stock_in_date);
                    ?></td>
                    <td><?php
                        echo $batch->quantity_stock_in;
                    ?></td>
                    <td><?php
                        echo to_currency($batch->unit_cost);
                    ?></td>
                    <td><?php
                        if(empty($batch->supplier_id)) {
                            echo nbs(1);
                        }
                        else {
                            $supplier = new Supplier_Model($batch->supplier_id);
                            echo anchor(
                                site_url('admin/supplier/edit/'.$batch->supplier_id),
                                $supplier->supplier_name
                            );
                        }
                    ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="box">
    <div class="box-heading"><?php
        echo lang('product_add_batch');
    ?></div>
    <div class="box-content">
        <form id="form_batch" method="POST" 
              action="<?php echo site_url("admin/product/save_batch/".$product->id);?>">
            <table class="form" width="100%">
                <tbody>
                    <tr>
                        <td><?php
                            echo lang('product_from_supplier');
                        ?></td>
                        <td colspan="3"><?php
                            echo form_input(array(
                                'id'    => 'supplier',
                                'name'  => 'supplier',
                                'class' => 'validate[required]',
                            ));
                            echo form_hidden('supplier_id', '');
                        ?></td>
                    </tr>
                    <tr>
                        <td><?php
                            echo lang('product_quantity_stock_in');
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'quantity_stock_in',
                                'name'  => 'quantity_stock_in',
                                'class' => 'validate[required] positive-integer',
                            ));
                            echo form_hidden('supplier_id', '');
                        ?></td>
                        <td><?php
                            echo lang('product_unit_cost');
                        ?></td>
                        <td><?php
                            echo form_input(array(
                                'id'    => 'unit_cost',
                                'name'  => 'unit_cost',
                                'class' => 'validate[required] positive',
                            ));
                        ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="buttons">
                <div class="right"><?php
                        echo button_link(
                            false,
                            lang('save'),
                            array('id' => 'save_batch')
                        );
                ?></div>
            </div>
        </form>
    </div>
</div>
