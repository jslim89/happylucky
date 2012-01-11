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
    'menu/menu.css',
    'lightbox/jquery.lightbox-0.5.css',
    'nivo-slider/nivo-slider.css',
    'nivo-slider/themes/default/default.css',
    'nivo-slider/themes/orman/orman.css',
    'nivo-slider/themes/pascal/pascal.css',
    'validationEngine.jquery.css',
    'view.css',
    'main.css',
);

foreach ($styles as $css)
    echo link_tag('common/css/' . $css) . "\n";
