<script type="text/javascript">
$(document).ready(function() {
    var q = query_string('q');
    if(q != null) $('input#q').val(q);
});
</script>
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
                'class' => 'button',
            ));?></td>
        </tr>
<!--
        <tr>
            <td><span id="advance_search" class="hand-cursor">
            <?php echo lang('advanced_search');?>
            </span></td>
        </tr>
-->
    </table>
</form>
