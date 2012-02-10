<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
});
</script>

<?php echo clear_div();?>

<!-- Search box -->
<div class="grid_16 search">
    <?php
    $this->load->view('common/search_form', $search_form_info);
    ?>
</div>
<!-- End Search box -->

<?php echo clear_div();?>

<!-- Pagination -->
<div class="grid_16 pagination">
    <span class="pagin"><?php
        echo $pagin;
    ?></span>
    <?php
        echo lang('page').nbs(2);
        echo $pagination->create_links().nbs(1);
    ?>
</div>
<!-- End Pagination -->

<?php echo clear_div();?>

<div class="grid_16">
    <?php if(sizeof($monks) == 0): ?>
        <span class="warning"><?php echo lang('monk_no_monk'); ?></span>
    <?php else: ?>
        <table width="100%">
        <?php foreach($monks as $monk): ?>
            <tr id="monk_list_<?php echo $monk->id; ?>">
                <td width="25%"><?php 
                    $monk_url = site_url('monk/view/'.$monk->id);
                    $image_url = empty($monk->primary_image_url)
                        ? default_image_path()
                        : $monk->primary_image_url;
                    echo anchor(
                        $monk_url,
                        img(array(
                            'src'    => $image_url,
                            'alt'    => $monk->monk_name,
                            'width'  => 80,
                            'height' => 80,
                        ))
                    );
                ?></td>
                <td width="*"><?php
                echo anchor($monk_url, $monk->monk_name);
                echo br(1);
                echo '<span class="expander">'.$monk->monk_story.'</span>';
                ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
