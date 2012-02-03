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
        <div id="header-login">
            <div id="header-welcome"><?php 
                $username = get_session('customer_id') 
                    ? anchor(base_url('user'), get_session('username')) 
                    : lang('guest');
                echo lang('welcome').', '.$username;
            ?></div>
            <!-- Login Bar -->
            <?php if(!get_session('customer_id')) {
                    // Login
                    $this->load->view('common/login');
                    // End Login
                  }
                  else {
                      // Logout
            ?>
                <div id="logout-topnav" class="topnav">
                    <a href="<?php echo site_url('user/logout').'?url='.current_url();?>" class="signout">
                        <span><?php echo lang('user_signout');?></span>
                    </a>
                </div>
            <?php
                      // End Logout
                  }
            ?>
            <!-- End Login Bar -->
        </div>
        <div id="header-links" style="float:right;"><?php 
            echo anchor(
                site_url('user'),
                lang('user_account')
            );
            echo anchor(
                site_url('cart'),
                lang('shopping_cart')
            );
            echo anchor(
                site_url('cart/checkout'),
                lang('cart_check_out')
            );
        ?></div>
    </div>
</div>
<!-- End Header -->

<?php echo clear_div();?>

<!-- Top Menu -->
<div class="grid_16">
<?php 
$list = array(
    anchor(site_url(''), lang('home')),
    '<a href="#">'.lang('product').'</a>' => array(
        anchor(site_url('product').'?category=amulet', lang('amulet')) => array(
            anchor(site_url('product').'?category=amulet&type=retail', lang('retail')),
            anchor(site_url('product').'?category=amulet&type=wholesale', lang('wholesale')),
        ),
        anchor(site_url('product').'?category=accessories', lang('accessories')) => array(
            anchor(site_url('product').'?category=accessories&type=retail', lang('retail')),
            anchor(site_url('product').'?category=accessories&type=wholesale', lang('wholesale')),
        ),
    ),
    anchor(site_url('monk'), lang('monk')),
    anchor(site_url('order'), lang('orders')),
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
    <!-- Content DIV (For normal user is grid_16) -->
    <div class="grid_16">
