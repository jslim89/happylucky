<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('span[id^=edit_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            redirect('user/edit/'+id);
        });
    });
    $('span[id^=delete_]').each(function() {
        $(this).click(function() {
            var id = get_element_index($(this));
            var delete_url = base_url + 'admin/user/delete/' + id;
            delete_row_confirmation(delete_url, 'user_row_'+id);
        });
    });

    $('#btn_delete').click(function() {
        var delete_urls = [];
        var row_ids     = [];
        $.each($('.delete_check:checked'), function(i) {
            var id = $(this).val();
            row_ids[id]     = 'user_row_'+id;
            delete_urls[id] = base_url + 'admin/user/delete/' + id;
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
        onclick="redirect('<?php echo site_url('admin/user/add');?>');" />
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
            <th><?php echo lang('email');?></th>
            <th><?php echo lang('user_first_name');?></th>
            <th><?php echo lang('user_last_name');?></th>
            <th width="5%"><?php echo lang('edit');?></th>
        </tr>
        <?php foreach($users as $user):?>
        <tr id="user_row_<?php echo $user->id; ?>">
            <td><?php
                echo form_checkbox(array(
                    'name'  => 'check_'.$user->id,
                    'id'    => 'check_'.$user->id,
                    'value' => $user->id,
                    'class' => 'delete_check',
                ));
            ?></td>
            <td><?php 
                echo anchor(
                    site_url('admin/user/edit/'.$user->id),
                    $user->email
                );
            ?></td>
            <td><?php echo $user->first_name; ?></td>
            <td><?php echo $user->last_name; ?></td>
            <td>
                <ul id="icons" class="ui-widget ui-helper-clearfix" style="">
                    <li class="ui-state-default ui-corner-all">
                        <span id="edit_<?php echo $user->id; ?>" class="ui-icon ui-icon-pencil"
                            title="<?php echo lang('edit');?>"></span>
                    </li>
                    <li class="ui-state-default ui-corner-all">
                        <span id="delete_<?php echo $user->id; ?>" class="ui-icon ui-icon-trash"
                            title="<?php echo lang('delete');?>"></span>
                    </li>
                </ul>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
