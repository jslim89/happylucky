<form id="search_form" method="GET" 
      action="<?php echo $search_url;?>">
    <table class="search_table">
        <tr>
            <td><?php echo form_input(array(
                'id'    => 'q',
                'name'  => 'q',
            ));?></td>
            <td><?php echo form_submit(array(
                'value' => lang('search'),
            ));?></td>
        </tr>
        <tr>
            <td><span id="advance_search">
            <?php echo lang('advanced_search');?>
            </span></td>
        </tr>
    </table>
</form>
