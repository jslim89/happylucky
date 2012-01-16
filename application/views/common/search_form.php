<script type="text/javascript">
$(document).ready(function() {
    var q = query_string('q');
    if(q != null) $('input#q').val(q);
    $('#search_form').validationEngine('attach');
    $('#search_form_submit').click(function() {
        $('#search_form').submit();
    });
});
</script>
<form id="search_form" method="GET" 
      action="<?php echo $search_url;?>">
    <table class="search_table">
        <tr>
            <td><?php echo form_input(array(
                'id'    => 'q',
                'name'  => 'q',
                'class' => 'validate[required]',
            ));?></td>
            <td><?php echo button_link(
                false,
                lang('search'),
                array('id' => 'search_form_submit')
            );?></td>
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
