<?php
$error_msg = $this->session->flashdata ('upload_error');
if( ! empty($error_msg)): ?>
    <div class="warning"><?php
            echo lang('error').br(1);
            echo $error_msg;
    ?></div>
<?php endif; ?>

<div class="box">
    <div class="box-heading"><?php
        echo lang('upload').' '.lang('images');
    ?></div>
    <div class="box-content">
        <form id="upload_image" method="POST" enctype="multipart/form-data"
              action="<?php echo site_url('admin/banner/upload');?>">
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
                    array('id' => 'btn_upload_image')
                );
            ?>
            </div>
        </form>
    </div>
</div>

<?php
$delete_success = $this->session->flashdata ('delete_success');
if( ! empty($delete_success)): ?>
    <div class="success"><?php
            echo nl2br($delete_success);
    ?></div>
<?php endif; ?>

<?php
$delete_failed = $this->session->flashdata ('delete_failed');
if( ! empty($delete_failed)): ?>
    <div class="warning"><?php
            echo nl2br($delete_failed);
    ?></div>
<?php endif; ?>

<?php if(sizeof($images) == 0): ?>
    <div class="warning"><?php
        echo lang('no_banner');
    ?></div>
<?php else: ?>
    <form id="delete_image" method="POST"
        action="<?php echo site_url('admin/banner/delete'); ?>">
        <div class="buttons">
            <div class="right"><?php
                echo button_link(
                    false,
                    lang('delete'),
                    array('id' => 'btn_delete')
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
                </tr>
            </thead>
            <tbody>
                <?php foreach($images as $image): ?>
                <tr id="existing_image_<?php echo basename($image);?>">
                    <td><?php
                    echo form_checkbox(array(
                        'name'  => 'check[]',
                        'id'    => 'check_'.basename($image),
                        'value' => basename($image),
                        'class' => 'delete_check',
                    ));?></td>
                    <td><?php
                    echo anchor(
                        $image,
                        img(array(
                        'src'    => $image,
                        'height' => '280',
                        )),
                        array('rel' => 'lightbox')
                    );
                    ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
<?php endif; ?>

<script type="text/javascript">
    $('#btn_upload_image').click(function() {
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
        $('#delete_image').submit();
    });
</script>
