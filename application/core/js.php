<script>
// global javascript variable
var base_url = '<?php echo base_url(); ?>';
var default_image_path = '<?php echo default_image_path(); ?>';

// language variable
lang_confirmation                     = '<?php echo lang('confirmation'); ?>';
lang_confirm_delete                   = '<?php echo lang('confirm_delete'); ?>';
lang_error                            = '<?php echo lang('error'); ?>';
lang_done                             = '<?php echo lang('done'); ?>';
lang_cancel                           = '<?php echo lang('cancel'); ?>';
lang_invalid_input                    = '<?php echo lang('invalid_input'); ?>';
lang_positive_integer_warning_message = '<?php echo lang('positive_integer_warning_message'); ?>';
lang_positive_integer_tooltip         = '<?php echo lang('positive_integer_tooltip');?>';
lang_positive_warning_message         = '<?php echo lang('positive_warning_message'); ?>';
lang_positive_tooltip                 = '<?php echo lang('positive_tooltip');?>';
lang_integer_warning_message          = '<?php echo lang('integer_warning_message'); ?>';
lang_integer_tooltip                  = '<?php echo lang('integer_tooltip');?>';
lang_more                             = '<?php echo lang('more');?>';
lang_less                             = '<?php echo lang('less');?>';

</script>
<?php 
// include file
$scripts = array(
    'jquery-1.7.min.js',
    'jquery-ui-1.8.16.custom.min.js',
    'jquery.validationEngine-en.js',
    'jquery.validationEngine.js',
    'jquery.numeric.js',
    'jquery.lightbox-0.5.js',
    'jquery.query-2.1.7.js',
    'jquery.cookie.js',
    'jquery.expander.min.js',
    'login/jquery.pop.js',
    'login/jquery.tipsy.js',
    'login.js',
    'common.js',
);

foreach ($scripts as $js)
    echo script_tag('common/js/' . $js) . "\n";
?>
