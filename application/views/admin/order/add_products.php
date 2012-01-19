<?php echo clear_div(); ?>
<script type="text/javascript">
$(function() {
    $('#save_form_add_product').click(function() {
        $('#form_add_product').submit();
    });

    $('#btn_insert').click(function() {
        var idx = $('select[name=product_selection]').val();
        var product_id         = $('input#temp_product_id').val();
        var product_name       = $('input#temp_product_name').val();
        var quantity_available = $('input#temp_product_quantity_available').val();
        var standard_price     = $('input#temp_product_standard_price').val();
        var min_quantity       = $('input#temp_product_min_quantity').val();
        $('#product_id_'+idx).val(product_id);
        $('#product_name_'+idx).text(product_name);
        $('#qty_available_'+idx).text(quantity_available);
        $('#min_quantity_'+idx).text(min_quantity);
        $('#standard_price_'+idx).text(standard_price);
        $('#unit_sell_price_'+idx).val(standard_price);

        $('#quantity_'+idx)[0].className = $('#quantity_'+idx).className.replace(/\bvalidate.*?\b/g, '');
        $('#quantity_'+idx).removeClass('^validate')
            .addClass('validate[required,max['+quantity_available+'],min['+min_quantity+']]');
    });

    $('#btn_add_more').click(function() {
        var last = $('div[id^=product_]').last();
        var last_idx = parseInt(get_element_index(last));

        var pid   = $('#product_id_'+last_idx).val();
        var qty   = $('#quantity_'+last_idx).val();
        var price = $('#unit_sell_price_'+last_idx).val();

        if(pid == '' || qty == '' || price == '') {
            ui_alert(
                '<?php echo lang('warning'); ?>'
                , '<?php echo lang('order_product_add_more_warning'); ?>'
            );
        }
        else {
            var next_idx = last_idx + 1;

            /* Clone a box */
            var clone = last.clone(true);
            clone.attr('id', 'product_' + next_idx);

            var old_heading = clone.find('div.box-heading').text();
            var new_heading = old_heading.replace(last_idx, next_idx);
            clone.find('div.box-heading')
                .text(new_heading);

            /* Bind to searching dropdown list */
            $('select[name=product_selection]').append($('<option></option>').val(next_idx).html(new_heading));
            /* End Bind to searching dropdown list */

            clone.find('#product_id_' + last_idx)
                .attr('id', 'product_id_' + next_idx)
                .attr('value', '')
                .attr('name', 'product_id['+next_idx+']');

            clone.find('#product_name_' + last_idx)
                .attr('id', 'product_name_' + next_idx)
                .attr('name', 'product_name['+next_idx+']')
                .text('');

            clone.find('#quantity_' + last_idx)
                .attr('id', 'quantity_' + next_idx)
                .attr('value', '')
                .attr('name', 'quantity['+next_idx+']');

            clone.find('#qty_available_' + last_idx)
                .attr('id', 'qty_available_' + next_idx)
                .text('');

            clone.find('#min_quantity_' + last_idx)
                .attr('id', 'min_quantity_' + next_idx)
                .text('');

            clone.find('#unit_sell_price_' + last_idx)
                .attr('id', 'unit_sell_price_' + next_idx)
                .attr('value', '')
                .attr('name', 'unit_sell_price['+next_idx+']');

            clone.find('#standard_price_' + last_idx)
                .attr('id', 'standard_price_' + next_idx)
                .text('');

            clone.show().insertAfter(last);
        }
    });

    $('#form_add_product').validationEngine('attach');

    $('input#search_product').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/product/ajax_search',
        focus: function(event, ui) {
            product_value = ui.item.product_code + ' - ' + ui.item.product_name;
            $(this).val(product_value);
            return false;
        },
        select: function(event, ui) {
            product_value = ui.item.product_code + ' - ' + ui.item.product_name;
            $(this).val(product_value);
            $('input#temp_product_id').val(ui.item.id);
            $('input#temp_product_name').val(product_value);
            $('input#temp_product_quantity_available').val(ui.item.quantity_available);
            $('input#temp_product_standard_price').val(ui.item.standard_price);
            $('input#temp_product_min_quantity').val(ui.item.min_quantity);

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
                .append('<a>' + format_product(item) + '</a>')
                .appendTo(ul);
    };
});

function format_product(product) {
    var img_src;
    if(product.primary_image_url == null) img_src = default_image_path;
    else img_src = product.primary_image_url;
    var str = '<img src="'+img_src+'" height="30" width="30" />';
    str += product.product_code + ' - ' + product.product_name;
    return str;
}
</script>
<div class="grid_4">
    <div class="box">
        <div class="box-heading"><?php
            echo lang('search').' '.lang('product');
        ?></div>
        <div class="box-content"><?php
            echo lang('search').' ';
            echo form_input(array(
                'id' => 'search_product',
            ));
            echo br(2).lang('for').' ';
            echo form_dropdown(
                'product_selection',
                array('0' => lang('product').' 0')
            );
            echo nbs(2);
            echo button_link(
                false,
                lang('insert'),
                array('id' => 'btn_insert')
            );
        ?></div>
        <input type="hidden" id="temp_product_id" />
        <input type="hidden" id="temp_product_name" />
        <input type="hidden" id="temp_product_quantity_available" />
        <input type="hidden" id="temp_product_standard_price" />
        <input type="hidden" id="temp_product_min_quantity" />
    </div>
</div>
<form id="form_add_product" method="POST" 
      action="<?php echo site_url("admin/order/add_product/".$order_id);?>">
    <div class="grid_11">
        <div class="box" id="product_0">
            <div class="box-heading"><?php
                echo lang('product').' 0';
            ?></div>
            <div class="box-content">
                <input type="hidden" id="product_id_0" name="product_id[0]" />
                <table class="form">
                    <tr>
                        <td class="label"><?php echo lang('product');?></td>
                        <td colspan="3">
                            <span id="product_name_0"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo lang('product_quantity');?></td>
                        <td><?php 
                            echo form_input(array(
                                'id'    => 'quantity_0',
                                'name'  => 'quantity[0]',
                                'class' => 'validate[required] positive-integer',
                            ));
                            echo br(1);
                            echo span(
                                lang('product_quantity_available'),
                                array(
                                    'class' => 'hint',
                                )
                            ).': ';
                            echo span(
                                '',
                                array(
                                    'id'    => 'qty_available_0',
                                    'class' => 'hint',
                                )
                            );
                            echo br(1);
                            echo span(
                                lang('product_min_quantity'),
                                array(
                                    'class' => 'hint',
                                )
                            ).': ';
                            echo span(
                                '',
                                array(
                                    'id'    => 'min_quantity_0',
                                    'class' => 'hint',
                                )
                            );
                        ?></td>
                        <td class="label"><?php echo lang('cart_unit_price');?></td>
                        <td><?php 
                            echo form_input(array(
                                'id'    => 'unit_sell_price_0',
                                'name'  => 'unit_sell_price[0]',
                                'class' => 'validate[required] positive',
                            ));
                            echo br(1);
                            echo span(
                                lang('product_standard_price'),
                                array(
                                    'class' => 'hint',
                                )
                            ).': ';
                            echo span(
                                '',
                                array(
                                    'id'    => 'standard_price_0',
                                    'class' => 'hint',
                                )
                            );
                        ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="buttons">
            <div class="left"><?php
                echo button_link(
                    false,
                    lang('more'),
                    array('id' => 'btn_add_more')
                );
            ?></div>
            <div class="right"><?php
                echo button_link(
                    false,
                    lang('save'),
                    array('id' => 'save_form_add_product')
                );
            ?></div>
        </div>
    </div>
</form>
<?php echo clear_div(); ?>
