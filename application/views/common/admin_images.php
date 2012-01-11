<table class="primary_image">
    <tr>
        <td class="label"><?php echo lang('primary_image');?></td>
    </tr>
    <?php if($primary_image_url): ?>
    <tr>
        <td rowspan="2"><?php
            echo img(array(
                'src'    => $primary_image_url,
                'alt'    => $primary_image_alt,
                'width'  => '200',
                'height' => '200',
            ));
        ?></td>
    </tr>
    <?php else: ?>
    <tr>
        <td rowspan="2"><?php
            echo img(array(
                'src'    => default_image_path(),
                'alt'    => lang('default').' '.lang('image'),
                'width'  => '200',
                'height' => '200',
            ));
        ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td>
            <form id="upload_primary" method="POST" enctype="multipart/form-data"
                  action="<?php echo $primary_upload_url;?>">
                <?php 
                    echo form_upload(array(
                        'name' => 'primary_image',
                        'id' => 'primary_image',
                    )); 
                    echo form_submit('upload_primary', lang('upload'), 'class="button"');
                ?>
            </form>
        </td>
    </tr>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $('#add_more').click(function() {
            var last = $('tr[id^=tr_image_]').last();
            var last_idx = parseInt(get_element_index(last));
            var next_idx = last_idx + 1;

            var clone = last.clone(true);
            clone.attr('id', 'tr_image_' + next_idx);
            clone.find('#image_' + last_idx)
                .attr('id', 'image_' + next_idx)
                .attr('value', '')
                .attr('name', 'image_'+next_idx);
            clone.show().insertAfter(last);
        });

        $('#btn_delete').click(function() {
            var delete_urls = [];
            var row_ids     = [];
            $.each($('.delete_check:checked'), function(i) {
                var id = $(this).val();
                row_ids[id]     = 'existing_image_'+id;
                delete_urls[id] = '<?php echo $delete_image_url;?>' + id;
            });
            delete_row_confirmation(delete_urls, row_ids);
        });

        $('span[id^=edit_]').each(function() {
            $(this).click(function() {
                var id = get_element_index($(this));
                $('input#image_name_'+id).attr('readonly', false);
                $('textarea#image_desc_'+id).attr('readonly', false);
            });
        });

        $('span[id^=delete_]').each(function() {
            $(this).click(function() {
                var id = get_element_index($(this));
                var delete_url = '<?php echo $delete_image_url;?>'+id;
                delete_row_confirmation(delete_url, 'existing_image_'+id);
            });
        });

        $('span[id^=save_]').each(function() {
            $(this).click(function() {
                var id = get_element_index($(this));
                var img_name = $('input#image_name_'+id).val();
                var img_desc = $('textarea#image_desc_'+id).val();
                $.ajax({
                    url: '<?php echo $save_image_url;?>'+id,
                    data: 'image_name='+img_name+'&image_desc='+img_desc,
                    type: 'POST',
                    success: function(ret) {
                        var item = $.parseJSON(ret);
                        if(item.status == 1) { // update successful
                            $('#upd_msg_'+id)
                                .text('<?php echo lang('updated'); ?>')
                                .show()
                                .fadeOut(3000);
                        }
                        else if(item.status == 0) { // update failed
                            $('#upd_msg_'+id)
                                .text('<?php echo lang('update_failed'); ?>')
                                .show()
                                .fadeOut(3000);
                        }
                        else if(item.status == -1) { // Nothing has changed
                            $('#upd_msg_'+id)
                                .text('<?php echo lang('nothing_has_changed'); ?>')
                                .show()
                                .fadeOut(3000);
                        }
                        $('input#image_name_'+id).attr('readonly', true);
                        $('textarea#image_desc_'+id).attr('readonly', true);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                    }
                });
                $('input#image_name_'+id).attr('readonly', false);
                $('textarea#image_desc_'+id).attr('readonly', false);
            });
        });
    });
</script>
<form id="upload_image" method="POST" enctype="multipart/form-data"
      action="<?php echo $upload_url;?>">
    <table class="image_upload">
        <tr>
            <td colspan="2">
                <div class="error">
                <?php
                    $error_msg = $this->session->flashdata ('upload_error');
                    if( ! empty($error_msg)) {
                        echo lang('error').br(1);
                        echo $error_msg;
                    }
                ?>&nbsp;
                </div>
            </td>
        </tr>
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
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2"><?php
                echo form_button(array(
                    'name'  => 'btn_delete',
                    'id'    => 'btn_delete',
                    'content' => lang('delete'),
                ));
            ?></td>
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
<td colspan='5'><?php
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
<tr id="existing_image_<?php echo $image->id;?>">
    <td><?php
    echo form_checkbox(array(
        'name'  => 'check_'.$image->id,
        'id'    => 'check_'.$image->id,
        'value' => $image->id,
        'class' => 'delete_check',
    ));?></td>
    <td><?php
    echo anchor(
        $image->url,
        img(array(
        'src'    => $image->url,
        'alt'    => $image->alt,
        'width'  => '100',
        'height' => '100',
        )),
        array('rel' => 'lightbox')
    );
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
            <li class="ui-state-default ui-corner-all">
                <span id="save_<?php echo $image->id; ?>" class="ui-icon ui-icon-check"
                    title="<?php echo lang('save');?>"></span>
            </li>
        </ul>
        <span id="upd_msg_<?php echo $image->id; ?>"></span>
    </td>
</tr>
<?php endforeach;
}
?>
    </tbody>
</table>
