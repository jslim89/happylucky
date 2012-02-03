<div class="box" style="float: left;width: 45%; margin: 0px 30px 10px 30px;">
    <div class="box-heading"><?php
        echo lang('primary_image');
    ?></div>
    <div class="box-content center">
        <?php
        if($primary_image_url) {
            echo img(array(
                'src'    => $primary_image_url,
                'alt'    => $primary_image_alt,
                'width'  => '200',
                'height' => '200',
            ));
        }
        else {
            echo img(array(
                'src'    => default_image_path(),
                'alt'    => lang('default').' '.lang('image'),
                'width'  => '200',
                'height' => '200',
            ));
        }
        ?>
        <div class="buttons">
            <form id="upload_primary" method="POST" enctype="multipart/form-data"
                  action="<?php echo $primary_upload_url;?>">
                <?php 
                    echo form_upload(array(
                        'name' => 'primary_image',
                        'id' => 'primary_image',
                    )); 
                    echo nbs(2);
                    echo button_link(
                        false,
                        lang('upload'),
                        array('id' => 'btn_upload_primary')
                    );
                ?>
            </form>
        </div>
    </div>
</div>
<div class="box" style="width: 45%;float:left;">
    <div class="box-heading"><?php
        echo lang('upload').' '.lang('images');
    ?></div>
    <div class="box-content center">
        <form id="upload_image" method="POST" enctype="multipart/form-data"
              action="<?php echo $upload_url;?>">
            <table class="image_upload">
                <tr id="tr_image_0">
                    <td><?php 
                        echo form_upload(array(
                            'name' => 'image_0',
                            'id' => 'image_0',
                        )); 
                    ?></td>
                </tr>
            </table>
            <div class="buttons right">
            <?php 
                echo button_link(
                    false,
                    lang('more'),
                    array(
                        'id' => 'add_more',
                        'name' => 'add_more',
                    )
                );
                echo nbs(2);
                echo button_link(
                    false,
                    lang('upload'),
                    array('id' => 'btn_upload_addition_image')
                );
            ?>
            </div>
        </form>
    </div>
</div>
<div style="clear:both;">&nbsp;</div>

<?php if(sizeof($images) == 0): ?>
    <div class="warning"><?php
        echo lang('no_additional_images');
    ?></div>
<?php else: ?>
    <div class="buttons">
        <div class="right"><?php
            echo button_link(
                false,
                lang('delete'),
                array('id' => 'btn_delete')
            );
        ?></div>
        <div class="left"><?php
            echo div(
                lang('delete_image_hint'),
                array('class' => 'hint')
            );
        ?></div>
    </div>
    <table class="list">
        <thead>
            <tr>
                <td width="1"><?php
                    echo form_checkbox(array(
                        'name'  => 'check_all',
                        'id'    => 'check_all',
                        'value' => 'CHECK_ALL',
                    ));
                ?></td>
                <td>
                <?php echo lang('images'); ?>
                </td>
                <td>
                <?php echo lang('image_name'); ?>
                </td>
                <td>
                <?php echo lang('description'); ?>
                </td>
                <td>
                <?php echo lang('edit'); ?>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($images as $image): ?>
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
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_upload_primary').click(function() {
            $('#upload_primary').submit();
        });
        $('#btn_upload_addition_image').click(function() {
            $('#upload_image').submit();
        });
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
