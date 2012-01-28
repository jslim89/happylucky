<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function() {
    $('#back').click(function() {
        redirect(base_url+'admin/amulet_type');
    });

    $('#save_amulet_type_add_edit').click(function() {
        $('#amulet_type_add_edit').submit();
    });

    $('#amulet_type_add_edit').validationEngine('attach');
    var is_add_new = <?php echo empty($amulet_type->id) ? 'true' : 'false'; ?>;
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

        <?php if($this->session->flashdata('record_saved')): ?>
        <div>
            <div class="success"><?php
                echo $this->session->flashdata('record_saved');
            ?></div>
        </div>
        <?php clear_div(); ?>
        <?php endif; ?>

        <form id="amulet_type_add_edit" method="POST" 
              action="<?php echo site_url("admin/amulet_type/save/".$amulet_type->id);?>">
            <table class="form">
                <tr>
                    <td class="label"><?php echo lang('amulet_type_name');?></td>
                    <td>
                        <?php 
                            echo form_input(array(
                                'name'  => 'amulet_type_name',
                                'id'    => 'amulet_type_name',
                                'value' => $amulet_type->amulet_type_name,
                                'class' => 'validate[required] text'
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="txt-label"><?php echo lang('amulet_type_description');?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php 
                            echo form_textarea(array(
                                'name'  => 'amulet_desc',
                                'id'    => 'amulet_desc',
                                'value' => $amulet_type->amulet_desc,
                                'row'   => '7',
                                'class' => 'validate[required] wysiwyg'
                            ));
                        ?>
                    </td>
                </tr>
            </table>
            <div class="buttons">
                <div class="right"><?php
                    echo button_link(
                        false,
                        lang('back'),
                        array('id' => 'back')
                    );
                    echo nbs(2);
                    echo button_link(
                        false,
                        lang('save'),
                        array('id' => 'save_amulet_type_add_edit')
                    );
                ?></div>
            </div>
        </form>
    </div>
    <div id="images">
        <?php $this->load->view('common/admin_images', $image_upload);?>
    </div>
</div>
