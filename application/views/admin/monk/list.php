<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Pagination -->
<div class="grid_10">
    <?php echo $pagination->create_links() ? $pagination->create_links() : nbs(1);?>
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
            <th width="20%"><?php echo lang('monk_name');?></th>
            <th width="75%"><?php echo lang('monk_story');?></th>
        </tr>
        <?php foreach($monks as $monk):?>
        <tr>
            <td><?php
                echo form_checkbox(array(
                    'name'  => 'check_'.$monk->id,
                    'id'    => 'check_'.$monk->id,
                    'value' => $monk->id,
                    'class' => 'delete_check',
                ));
            ?></td>
            <td><?php 
                echo anchor(
                    site_url('admin/monk/edit/'.$monk->id),
                    $monk->monk_name
                );
            ?></td>
            <td><?php echo $monk->monk_story;?></td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
