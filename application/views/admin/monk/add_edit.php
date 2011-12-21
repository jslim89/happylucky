<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#monk_add_edit').validationEngine('attach');
    var is_add_new = <?php echo empty($monk->id) ? 'true' : 'false'; ?>;
    var tabs_disable = (is_add_new) ? [1] : [];
    var tabs_selected = (query_string('tab') == null) ? 0 : query_string('tab');
    $('#tabs').tabs({
        disabled: tabs_disable,
        selected: tabs_selected
    });
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
                <tr>
                    <td colspan="2" class="txt-label"><?php echo lang('monk_story');?></td>
                </tr>
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
        <?php $this->load->view('common/admin_images', $image_upload);?>
    </div>
</div>
