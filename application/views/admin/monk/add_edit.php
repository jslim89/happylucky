<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('.wysiwyg').ckeditor(
        function(){
        }
    );
    $('#monk_add_edit').validationEngine('attach');
});
</script>

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
        <tr><td colspan="2" class="txt-label"><?php echo lang('monk_story');?></td></tr>
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
