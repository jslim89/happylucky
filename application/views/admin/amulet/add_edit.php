<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'admin/amulet');
    });

    $('#amulet_add_edit').validationEngine('attach');

    var is_add_new = <?php echo empty($amulet->id) ? 'true' : 'false'; ?>;
    var tabs_disable = (is_add_new) ? [1] : [];
    var tabs_selected = (query_string('tab') == null) ? 0 : query_string('tab');
    $('#tabs').tabs({
        disabled: tabs_disable,
        selected: tabs_selected
    });

    $('input#amulet_type').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/amulet_type/ajax_search',
        focus: function(event, ui) {
            $(this).val(ui.item.amulet_type_name);
            return false;
        },
        select: function(event, ui) {
            $(this).val(ui.item.amulet_type_name);
            $('input[name=amulet_type_id]').val(ui.item.id);
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
                .append('<a>' + format_amulet_type(item) + '</a>')
                .appendTo(ul);
    };

    $('input#amulet_monk').autocomplete({
        highlight: true,
        minLength: 1,
        scroll: true,
        dataType: 'json',
        source: base_url + 'admin/monk/ajax_search',
        focus: function(event, ui) {
            $(this).val(ui.item.monk_name);
            return false;
        },
        select: function(event, ui) {
            $(this).val(ui.item.monk_name);
            $('input[name=monk_id]').val(ui.item.id);
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
                .append('<a>' + format_monk(item) + '</a>')
                .appendTo(ul);
    };
});

function format_monk(monk) {
    var img_src;
    if(monk.primary_image_url == null) img_src = default_image_path;
    else img_src = monk.primary_image_url;
    var str = '<img src="'+img_src+'" height="30" width="30" />';
    str += monk.monk_name;
    return str;
}

function format_amulet_type(amulet_type) {
    var img_src;
    if(amulet_type.primary_image_url == null) img_src = default_image_path;
    else img_src = amulet_type.primary_image_url;
    var str = '<img src="'+img_src+'" height="30" width="30" />';
    str += amulet_type.amulet_type_name;
    return str;
}
</script>

<div id="tabs">
    <ul>
        <li><a href="#general"><?php echo lang('general'); ?></a></li>
        <li><a href="#images"><?php echo lang('images'); ?></a></li>
    </ul>
    <div id="general">
        <form id="amulet_add_edit" method="POST" 
              action="<?php echo site_url("admin/amulet/save/".$amulet->id);?>">
            <table>
                <tr>
                    <td class="label"><?php echo lang('amulet_name');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'amulet_name',
                                'id'    => 'amulet_name',
                                'value' => $amulet->amulet_name,
                                'class' => 'validate[required] text'
                            ));
                        ?>
                    </td>
                    <td class="label"><?php echo lang('amulet_code');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'amulet_code',
                                'id'    => 'amulet_code',
                                'value' => $amulet->amulet_code,
                                'class' => 'validate[required,ajax[ajaxAmuletCode]] text'
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('amulet_produced_date');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'produced_date',
                                'id'    => 'produced_date',
                                'value' => $amulet->produced_date,
                                'class' => 'validate[required] text'
                            ));
                        ?>
                    </td>
                    <td class="label"><?php echo lang('amulet_produced_place');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'produced_place',
                                'id'    => 'produced_place',
                                'value' => $amulet->produced_place,
                                'class' => 'validate[required] text'
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo lang('amulet_monk');?></td>
                    <td>
                        <?php 
                            $monk = (sizeof($amulet->monk) < 1) ? new Monk_Model() : $amulet->monk;
                            echo form_input(array(
                                'name'  => 'amulet_monk',
                                'id'    => 'amulet_monk',
                                'value' => $monk->monk_name,
                                'class' => 'validate[required] text'
                            ));
                            echo form_hidden('monk_id', $amulet->monk_id);
                        ?>
                    </td>
                    <td class="label"><?php echo lang('amulet_amulet_type');?></td>
                    <td>
                        <?php 
                            $amulet_type = (sizeof($amulet->amulet_type) < 1)
                                ? new Amulet_Type_Model() 
                                : $amulet->amulet_type;
                            echo form_input(array(
                                'name'  => 'amulet_type',
                                'id'    => 'amulet_type',
                                'value' => $amulet_type->amulet_type_name,
                                'class' => 'validate[required] text'
                            ));
                            echo form_hidden('amulet_type_id', $amulet->amulet_type_id);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="txt-label"><?php echo lang('amulet_description');?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php 
                            echo form_textarea(array(
                                'name'  => 'amulet_desc',
                                'id'    => 'amulet_desc',
                                'value' => $amulet->amulet_desc,
                                'row'   => '7',
                                'class' => 'validate[required] wysiwyg'
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
                    echo form_submit('save_amulet', lang('save'), 'class="button"');
                ?>
            </div>
        </form>
    </div>
    <div id="images">
        <?php $this->load->view('common/admin_images', $image_upload);?>
    </div>
</div>
