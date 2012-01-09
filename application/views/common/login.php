<div id="login-container">
  <div id="login-topnav" class="topnav"><a href="" class="signin"><span><?php echo lang('user_signin');?></span></a> </div>
  <fieldset id="login-signin_menu">
      <form method="post" id="login-signin" action="<?php echo site_url('welcome/login');?>">
      <label for="email"><?php echo lang('email');?></label>
      <input id="login_email" name="email" value="" title="<?php echo lang('email');?>" tabindex="4" type="text">
      </p>
      <p>
        <label for="password"><?php echo lang('user_password');?></label>
        <input id="login_password" name="password" value="" title="<?php echo lang('user_password');?>" tabindex="5" type="password">
      </p>
      <p class="remember">
        <input id="login-signin_submit" value="<?php echo lang('user_signin');?>" tabindex="6" type="submit">
        <input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox">
        <label for="remember"><?php echo lang('user_remember_me');?></label>
      </p>
      <p class="forgot"><a href="<?php echo site_url('welcome/forgot_password');?>" id="resend_password_link"><?php echo lang('user_forgot_password');?>?</a> </p>
    <!--
      <p class="forgot-username">
        <a id="forgot_username_link"
            title="<?php echo lang('user_forgot_username_tooltip');?>" 
            href="#"><?php echo lang('user_forgot_username');?>?
        </a>
      </p>
    -->
      <p class="register">
        <a id="register_link"
            title="<?php echo lang('user_register_tooltip');?>" 
            href="<?php echo site_url('user/register');?>"><?php echo lang('user_register');?>?
        </a>
      </p>
    </form>
  </fieldset>
</div>
