<?php

// $styles = get_files_recursive('common/style/', 'css');
// include file
$styles = array(
    '960/960.css',
    '960/reset.css',
    '960/text.css',
    'jqueryui/jquery-ui-1.8.16.custom.css',
    'tipsy/tipsy.css',
    'login/front.css',
    'topmenu/style.css',
    'validationEngine.jquery.css',
    'main.css',
);

foreach ($styles as $css)
    echo link_tag('common/css/' . $css) . "\n";
