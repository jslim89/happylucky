<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(function() {
    $('#monk-tabs').tabs({
        <?php if(!$monk_id) echo "disabled: [1],";?>
        ajaxOptions: {
             error: function(xhr, status, index, anchor) {
                        $(anchor.hash).html(
                            "Couldn't load this tab. We'll try to "
                            + "fix this as soon as possible."
                        );
                    }
         }
    }).find('.ui-tabs-nav').sortable({ axis: 'x' });

})
</script>

<div class="grid_16 action-button">
    <input type="button" class="button" 
        value="<?php echo lang('back');?>" 
        onclick="redirect('<?php echo site_url('admin/monk');?>');" />
</div>
<?php echo clear_div();?>
<div class="grid_16">
    <div id="monk-tabs">
    <?php
        // If monk ID is false, means this is an ADD action
        $general_url = ($monk_id) ? "admin/monk/edit/".$monk_id :
                        "admin/monk/add";
        $list[] = anchor(site_url($general_url), lang('general'));
        $list[] = anchor(site_url('admin/monk/images_add_edit/'.$monk_id), lang('images'));
        echo ul($list);
    ?>
    </div>
</div>
<?php echo clear_div();?>
