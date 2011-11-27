<!-- Login Bar -->
<div class="grid_6">
<?php if(!get_session('user_id') || get_session('user_type') == 'ADMIN') {
        // Login
        $this->load->view('common/login');
        // End Login
      }
      else {
          // Logout
?>
    <div id="logout-topnav" class="topnav">
        <a href="<?php echo site_url('welcome/logout');?>" class="signout">
            <span><?php echo lang('user_signout');?></span>
        </a>
    </div>
<?php
          // End Logout
      }
?>
</div>
<!-- End Login Bar -->

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

<!-- Content DIV (For normal user is grid_16) -->
<div class="grid_16">
    <!-- Content -->
    <div class="content">
