<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'admin/supplier');
    });

    $('#supplier_add_edit').validationEngine('attach');

    $('input#country').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/country/ajax_search',
        focus: function(event, ui) {
            $(this).val(ui.item.country_name);
            return false;
        },
        select: function(event, ui) {
            $(this).val(ui.item.country_name);
            $('input[name=country_id]').val(ui.item.id);
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
                .append('<a>' + format_country(item) + '</a>')
                .appendTo(ul);
    };

});
</script>

<div id="general">
    <form id="supplier_add_edit" method="POST" 
          action="<?php echo site_url("admin/supplier/save/".$supplier->id);?>">
        <table>
            <tr>
                <td class="label"><?php echo lang('supplier_name');?></td>
                <td colspan="3">
                    <?php 
                        echo form_input(array(
                            'name'  => 'supplier_name',
                            'id'    => 'supplier_name',
                            'value' => $supplier->supplier_name,
                            'class' => 'validate[required] text'
                        ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang('address');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'address',
                            'id'    => 'address',
                            'value' => $supplier->address,
                            'class' => 'validate[required]'
                        ));
                    ?>
                </td>
                <td><?php echo lang('town');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'town',
                            'id'    => 'town',
                            'value' => $supplier->town,
                            'class' => ''
                        ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang('postcode');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'postcode',
                            'id'    => 'postcode',
                            'value' => $supplier->postcode,
                            'class' => 'positive_integer'
                        ));
                    ?>
                </td>
                <td><?php echo lang('city');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'city',
                            'id'    => 'city',
                            'value' => $supplier->city,
                            'class' => 'validate[required]'
                        ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang('state');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'state',
                            'id'    => 'state',
                            'value' => $supplier->state,
                            'class' => 'validate[required]'
                        ));
                    ?>
                </td>
                <td><?php echo lang('country');?></td>
                <td>
                    <?php 
                        $country = (sizeof($supplier->country) < 1)
                            ? new Country_Model() 
                            : $supplier->country;
                        echo form_input(array(
                            'name'  => 'country',
                            'id'    => 'country',
                            'value' => $country->country_name,
                            'class' => 'validate[required]'
                        ));
                        echo form_hidden('country_id', $supplier->country_id);
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang('supplier_contact');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'contact_no',
                            'id'    => 'contact_no',
                            'value' => $supplier->contact_no,
                            'class' => 'validate[required]'
                        ));
                    ?>
                </td>
                <td><?php echo lang('email');?></td>
                <td>
                    <?php 
                        echo form_input(array(
                            'name'  => 'email',
                            'id'    => 'email',
                            'value' => $supplier->email,
                            'class' => 'validate[required,custom[email]]'
                        ));
                    ?>
                </td>
            </tr>
        </table>
        <div class="right">
            <?php
                echo form_button(array(
                    'id'      => 'back',
                    'content' => lang('back'),
                ));
                echo form_submit('save_supplier', lang('save'), 'class="button"');
            ?>
        </div>
    </form>
</div>
