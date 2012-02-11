<!-- Header -->
<div class="header">
    <!-- Banner -->
    <div class="grid_6">
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
    <div class="grid_10">
        <!-- Login Bar -->
        <div id="logout-topnav" class="topnav">
            <a href="<?php echo site_url('admin/welcome/logout');?>" class="signout">
                <span><?php echo lang('user_signout');?></span>
            </a>
        </div>
        <!-- End Login Bar -->
    </div>
</div>
<!-- End Header -->
<?php echo clear_div();?>

<!-- Top Menu -->
<div class="grid_16">
<?php 
$list = array(
    anchor(site_url('admin/dashboard'), lang('dashboard')),
    '<a href="#">'.lang('management').'</a>' => array(
        anchor(site_url('admin/product'), lang('product_management')),
        anchor(site_url('admin/order'), lang('order_management')),
        anchor(site_url('admin/amulet'), lang('amulet_management')) => array(
            anchor(site_url('admin/amulet_type'), lang('amulet_type'))
        ),
        anchor(site_url('admin/monk'), lang('monk_management')),
        anchor(site_url('admin/supplier'), lang('supplier_management')),
        anchor(site_url('admin/user'), lang('user_management')),
        anchor(site_url('admin/customer'), lang('customer_management')),
        anchor(site_url('admin/banner'), lang('banner_management')),
    ),
    '<a href="#">'.lang('report').'</a>' => array(
        anchor(site_url('admin/report/sales_yearly'), lang('report_sales_report')) => array(
            anchor(site_url('admin/report/sales_yearly'), lang('report_yearly')),
            anchor(site_url('admin/report/sales_monthly'), lang('report_monthly')),
            anchor(site_url('admin/report/sales_daily'), lang('report_daily')),
        ),
        anchor(site_url('admin/report/product'), lang('report_product_report')),
        anchor(site_url('admin/report/customer'), lang('report_customer_report')),
    )
);
$topmenu = array();
$topmenu['list'] = $list;
$this->load->view('common/topmenu', $topmenu);
?>
</div>
<!-- End Top Menu -->

<?php echo clear_div();?>

<!-- Title -->
<div class="grid_16">
    <h1 title="<?php echo isset($title) ? $title : '';?>" class="title">
        <?php echo isset($title) ? $title : '';?>
    </h1>
</div>
<!-- End Title -->
<?php echo clear_div();?>

<?php if($this->session->flashdata('general_error')): ?>
<div class="grid_16 warning"><?php
    echo $this->session->flashdata('general_error');
?></div>
<?php echo clear_div();?>
<?php endif;?>

<?php if($this->session->flashdata('general_success')): ?>
<div class="grid_16 success"><?php
    echo $this->session->flashdata('general_success');
?></div>
<?php echo clear_div();?>
<?php endif;?>

<!-- Content -->
<div class="content">
    <!-- Content DIV -->
    <div class="grid_16">
