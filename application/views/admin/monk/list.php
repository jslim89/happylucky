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
});
</script>

<!-- Search box -->
<div class="grid_16 search">
    <form id="search_form" method="GET" 
          action="<?php echo site_url("admin/monk/search");?>">
        <?php 
        echo form_input(array(
            'id'    => 'q',
            'name'  => 'q',
        ));
        echo form_submit(array(
            'id'    => 'search',
            'name'  => 'search',
            'value' => lang('search'),
        ));
        ?>
    </form>
</div>
<!-- End Search box -->

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_10">
    <?php echo $pagination->create_links().nbs(1);?>
</div>
<!-- End Pagination -->

<!-- Action Button -->
<div class="grid_6 action-button">
    <input type="button" class="button" id="btn_delete" 
        value="<?php echo lang('delete');?>" />
    <input type="button" class="button" 
        value="<?php echo lang('add_new');?>" 
        onclick="redirect('<?php echo site_url('admin/monk/add');?>');" />
</div>
<!-- End Action Button -->
<?php echo clear_div();?>

<div class="grid_16">
    <table class="listing">
        <tr>
            <th width="5%"><?php
                echo form_checkbox(array(
                    'name'  => 'check_all',
                    'id'    => 'check_all',
                    'value' => 'CHECK_ALL',
                ));
            ?></th>
            <th width="20%"><?php echo lang('image');?></th>
            <th width="20%"><?php echo lang('monk_name');?></th>
            <th width="75%"><?php echo lang('monk_story');?></th>
            <th width="75%"><?php echo lang('edit');?></th>
        </tr>
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
    </table>
</div>
