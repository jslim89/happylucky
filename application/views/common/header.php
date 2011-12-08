<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $this->lang->load('general'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo isset($page_title) ? $page_title : 'Happy Lucky'; ?></title>
    <?php
    require_once "application/core/css.php";
    require_once "application/core/js.php";
    ?>
</head>
<body>
<!-- container_16 -->
<div class="container_16">

<!-- A container to keep the jQuery message dialog -->
<div id="message-dialog"></div>
<!-- A container to keep the jQuery confirm dialog -->
<div id="confirm-dialog"></div>

<!-- Header -->
<div class="header">
    <!-- Banner -->
    <div class="grid_10">
        <?php
            echo img(array(
                'src'    => 'images/banner.png',
                'alt'    => lang('banner_img_alt'),
                'class'  => '',
                'width'  => '300px',
                'height' => '116px',
                'title'  => '',
                'rel'    => '',
                'border' => '0',
            ));
        ?>
    </div>
    <!-- End Banner -->
