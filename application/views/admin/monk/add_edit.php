<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#monk_add_edit').validationEngine('attach');
    $('#tabs').tabs();
});
</script>

<div id="tabs">
    <ul>
        <li><a href="#general"><?php echo lang('general'); ?></a></li>
        <li><a href="#images"><?php echo lang('images'); ?></a></li>
    </ul>
    <div id="general">
        <form id="monk_add_edit" method="POST" 
              action="<?php echo site_url("admin/monk/save/".$monk->id);?>">
            <table>
                <tr>
                    <td class="label"><?php echo lang('monk_name');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'monk_name',
                                'id'    => 'monk_name',
                                'value' => $monk->monk_name,
                                'class' => 'validate[required] text'
                            ));
                        ?>
                    </td>
                </tr>
                <tr><td colspan="2" class="txt-label"><?php echo lang('monk_story');?></td></tr>
                <tr>
                    <td colspan="2">
                        <?php 
                            echo form_textarea(array(
                                'name'  => 'monk_story',
                                'id'    => 'monk_story',
                                'value' => $monk->monk_story,
                                'row'   => '7',
                                'class' => 'validate[required] wysiwyg'
                            ));
                        ?>
                    </td>
                </tr>
            </table>
            <div class="right">
                <?php echo form_submit('save_monk', lang('save'), 'class="button"');?>
            </div>
        </form>
    </div>
    <div id="images">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#add_more').click(function() {
                    var last = $('tr[id^=tr_image_]').last();
                    var last_idx = parseInt(get_element_index(last));
                    var next_idx = last_idx + 1;

                    var clone = $('#tr_image_0').clone(true);
                    clone.attr('id', 'tr_image_' + next_idx);
                    clone.find('#image_' + last_idx)
                        .attr('id', 'image_' + next_idx)
                        .attr('value', '')
                        .attr('name', 'image_'+next_idx);
                    clone.show().insertAfter(last);
                });
            });
        </script>
        <form id="monk_upload_image" method="POST" enctype="multipart/form-data"
              action="<?php echo site_url("admin/monk/upload/".$monk->id);?>">
            <table class="image_upload">
                <tr id="tr_image_0">
                    <td colspan="2">
                    <?php 
                        echo form_upload(array(
                            'name' => 'image_0',
                            'id' => 'image_0',
                        )); 
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php
                        echo form_submit('add_image', lang('upload'), 'class="button"');
                    ?>
                    </td>
                    <td>
                    <?php
                        echo form_button(array(
                            'id'      => 'add_more',
                            'name'    => 'add_more',
                            'content' => lang('more'),
                            'class'   => 'button'
                        ));
                    ?>
                    </td>
                </tr>
            </table>
        </form>
        <table class="image_display">
            <thead>
                <tr>
                    <th width="5%"><?php
                        echo form_checkbox(array(
                            'name'  => 'check_all',
                            'id'    => 'check_all',
                            'value' => 'CHECK_ALL',
                        ));
                    ?></th>
                    <th>
                    <?php echo lang('images'); ?>
                    </th>
                    <th>
                    <?php echo lang('image_name'); ?>
                    </th>
                    <th>
                    <?php echo lang('description'); ?>
                    </th>
                    <th>
                    <?php echo lang('edit'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
<?php if(sizeof($images) == 0) { ?>
<tr>
    <td><?php
        echo form_checkbox(array(
            'name'  => 'check_'.$monk->id,
            'id'    => 'check_'.$monk->id,
            'value' => $monk->id,
            'class' => 'delete_check',
        ));
    ?></td>
    <td colspan='2'><?php
        echo img(array(
            'src'    => base_url().'images/default.jpg',
            'alt'    => lang('default').' '.lang('image'),
            'width'  => '100',
            'height' => '100',
        ));
    ?></td>
</tr>
<?php }
else {
    foreach($images as $image): ?>
        <tr>
            <td><?php
            echo form_checkbox(array(
                'name'  => 'check_'.$image->id,
                'id'    => 'check_'.$image->id,
                'value' => $image->id,
                'class' => 'delete_check',
            ));?></td>
            <td><?php
            echo img(array(
                'src'    => $image->url,
                'alt'    => $image->alt,
                'width'  => '100',
                'height' => '100',
            ));
            ?></td>
            <td><?php
            echo form_input(array(
                'name'     => 'image_name['.$image->id.']',
                'id'       => 'image_name_'.$image->id,
                'value'    => $image->image_name,
                'readonly' => true,
            ));
            ?></td>
            <td><?php
            echo form_textarea(array(
                'name'     => 'image_desc['.$image->id.']',
                'id'       => 'image_desc_'.$image->id,
                'value'    => $image->image_desc,
                'rows'     => '4',
                'columns'  => '10',
                'readonly' => true,
            ));
            ?></td>
            <td>
        <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
            <li class="ui-state-default ui-corner-all">
                <span id="edit_<?php echo $image->id; ?>" class="ui-icon ui-icon-pencil"
                    title="<?php echo lang('edit');?>"></span>
            </li>
            <li class="ui-state-default ui-corner-all">
                <span id="delete_<?php echo $image->id; ?>" class="ui-icon ui-icon-trash"
                    title="<?php echo lang('delete');?>"></span>
            </li>
        </ul>
            </td>
        </tr>
<?php endforeach;
}
?>
            </tbody>
        </table>
    </div>
</div>
