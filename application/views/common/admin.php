<!-- Login Bar -->
<div id="logout-topnav" class="topnav grid_6">
    <a href="<?php echo site_url('admin/welcome/logout');?>" class="signout">
        <span><?php echo lang('user_signout');?></span>
    </a>
</div>
<!-- End Login Bar -->

<?php echo clear_div();?>

<!-- Top Menu -->
<div class="grid_16">
<?php 
$list = array(
    anchor(site_url('admin/dashboard'), lang('dashboard')),
    '<a href="#">'.lang('management').'</a>' => array(
        anchor(site_url('admin/product'), lang('product_management')),
        anchor(site_url('admin/order'), lang('order_management')) => array(
            anchor(site_url('admin/order/retail'), lang('retail')),
            anchor(site_url('admin/order/wholesale'), lang('wholesale')),
        ),
        anchor(site_url('admin/amulet'), lang('amulet_management')) => array(
            anchor(site_url('admin/amulet_type'), lang('amulet_type'))
        ),
        anchor(site_url('admin/monk'), lang('monk_management')),
        anchor(site_url('admin/supplier'), lang('supplier_management')),
        anchor(site_url('admin/user'), lang('user_management')),
    ),
    anchor(site_url('admin/report'), lang('report')),
);
$topmenu = array();
$topmenu['list'] = $list;
$this->load->view('common/admin-topmenu', $topmenu);
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

</div>
<!-- End Header -->
<?php echo clear_div();?>

<!-- Content DIV -->
<div class="grid_16">
    <!-- Content -->
    <div class="content">
