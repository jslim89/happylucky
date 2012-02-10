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

    $('#btn_add_new').click(function() {
        redirect('<?php echo site_url('admin/user/add'); ?>');
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
<div class="grid_10 pagination">
    <span class="pagin"><?php
        echo $pagin;
    ?></span>
    <?php
        echo lang('page').nbs(2);
        echo $pagination->create_links().nbs(1);
    ?>
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
                <td><?php echo lang('email');?></td>
                <td><?php echo lang('user_first_name');?></td>
                <td><?php echo lang('user_last_name');?></td>
                <td width="5%"><?php echo lang('edit');?></td>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>
</div>
