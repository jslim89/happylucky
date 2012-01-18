<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span[id^=edit_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            redirect('monk/edit/'+id);
        });
    });
    $('span[id^=delete_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            var delete_url = base_url + 'admin/monk/delete/' + id;
            delete_row_confirmation(delete_url, 'monk_row_'+id);
        });
    });

    $('#btn_delete').click(function() {
        var delete_urls = [];
        var row_ids     = [];
        $.each($('.delete_check:checked'), function(i) {
            var id = $(this).val();
            row_ids[id]     = 'monk_row_'+id;
            delete_urls[id] = base_url + 'admin/monk/delete/' + id;
        });
        delete_row_confirmation(delete_urls, row_ids);
    });

    $('#btn_add_new').click(function() {
        redirect('<?php echo site_url('admin/monk/add'); ?>');
    });

    /*
    $('span#advanced_search').click(function() {
    });
     */
});
</script>

<!-- Search box -->
<div class="grid_16 search">
    <?php $this->load->view('common/search_form', $search_form_info);?>
</div>
<!-- End Search box -->

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
        lang('delete'),
        array('id' => 'btn_delete')
    );
    echo nbs(2);
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
                <td width="1"><?php
                    echo form_checkbox(array(
                        'name'  => 'check_all',
                        'id'    => 'check_all',
                        'value' => 'CHECK_ALL',
                    ));
                ?></td>
                <td width="15%"><?php echo lang('image');?></td>
                <td width="20%"><?php echo lang('monk_name');?></td>
                <td width="75%"><?php echo lang('monk_story');?></td>
                <td width="5%"><?php echo lang('edit');?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($monks as $monk):?>
            <tr id="monk_row_<?php echo $monk->id; ?>">
                <td><?php
                    echo form_checkbox(array(
                        'name'  => 'check_'.$monk->id,
                        'id'    => 'check_'.$monk->id,
                        'value' => $monk->id,
                        'class' => 'delete_check',
                    ));
                ?></td>
                <td><?php 
                    $image_src = $monk->primary_image_url
                        ? $monk->primary_image_url
                        : default_image_path();
                    echo anchor(
                        site_url('admin/monk/edit/'.$monk->id),
                        img(array(
                            'src'    => $image_src,
                            'alt'    => $monk->monk_name,
                            'width'  => '100',
                            'height' => '100',
                        ))
                    );
                ?></td>
                <td><?php 
                    echo anchor(
                        site_url('admin/monk/edit/'.$monk->id),
                        $monk->monk_name
                    );
                ?></td>
                <td><?php echo $monk->monk_story;?></td>
                <td>
                    <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                        <li class="ui-state-default ui-corner-all">
                            <span id="edit_<?php echo $monk->id; ?>" class="ui-icon ui-icon-pencil"
                                title="<?php echo lang('edit');?>"></span>
                        </li>
                        <li class="ui-state-default ui-corner-all">
                            <span id="delete_<?php echo $monk->id; ?>" class="ui-icon ui-icon-trash"
                                title="<?php echo lang('delete');?>"></span>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
