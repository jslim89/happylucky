<form id="search_form" method="GET" 
      action="<?php echo $search_url;?>">
    <?php 
    echo form_input(array(
        'id'    => 'q',
        'name'  => 'q',
    ));
    echo form_submit(array(
        'value' => lang('search'),
    ));
    ?>
</form>
