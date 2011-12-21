<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span[id^=edit_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            redirect('amulet/edit/'+id);
        });
    });
    $('span[id^=delete_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            var delete_url = base_url + 'admin/amulet/delete/' + id;
            delete_row_confirmation(delete_url, 'amulet_row_'+id);
        });
    });

    $('#btn_delete').click(function() {
        var delete_urls = [];
        var row_ids     = [];
        $.each($('.delete_check:checked'), function(i) {
            var id = $(this).val();
            row_ids[id]     = 'amulet_row_'+id;
            delete_urls[id] = base_url + 'admin/amulet/delete/' + id;
        });
        delete_row_confirmation(delete_urls, row_ids);
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
<div class="grid_6 action-button">
    <input type="button" class="button" id="btn_delete" 
        value="<?php echo lang('delete');?>" />
    <input type="button" class="button" 
        value="<?php echo lang('add_new');?>" 
        onclick="redirect('<?php echo site_url('admin/amulet/add');?>');" />
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
            <th width="20%"><?php echo lang('amulet_name');?></th>
            <th width="75%"><?php echo lang('amulet_story');?></th>
            <th width="75%"><?php echo lang('edit');?></th>
        </tr>
        <?php foreach($amulets as $amulet):?>
        <tr id="amulet_row_<?php echo $amulet->id; ?>">
            <td><?php
                echo form_checkbox(array(
                    'name'  => 'check_'.$amulet->id,
                    'id'    => 'check_'.$amulet->id,
                    'value' => $amulet->id,
                    'class' => 'delete_check',
                ));
            ?></td>
            <td><?php 
                $image_src = $amulet->amulet_type->primary_image_url
                    ? $amulet->amulet_type->primary_image_url
                    : default_image_path();
                echo anchor(
                    site_url('admin/amulet/edit/'.$amulet->id),
                    img(array(
                        'src'    => $image_src,
                        'alt'    => $amulet->amulet_name,
                        'width'  => '100',
                        'height' => '100',
                    ))
                );
            ?></td>
            <td><?php 
                echo anchor(
                    site_url('admin/amulet/edit/'.$amulet->id),
                    $amulet->amulet_code
                );
            ?></td>
            <td><?php 
                echo anchor(
                    site_url('admin/amulet/edit/'.$amulet->id),
                    $amulet->amulet_name
                );
            ?></td>
            <td><?php echo $amulet->amulet_desc;?></td>
            <td>
                <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                    <li class="ui-state-default ui-corner-all">
                        <span id="edit_<?php echo $amulet->id; ?>" class="ui-icon ui-icon-pencil"
                            title="<?php echo lang('edit');?>"></span>
                    </li>
                    <li class="ui-state-default ui-corner-all">
                        <span id="delete_<?php echo $amulet->id; ?>" class="ui-icon ui-icon-trash"
                            title="<?php echo lang('delete');?>"></span>
                    </li>
                </ul>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
