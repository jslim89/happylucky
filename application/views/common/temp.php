<?php
/* This is a temporary page that only last for few second
 * For example, after a customer registered an account,
 * it will be redirected to this page and just shown some
 * message that ask the customer to check his/her mailbox.
 */
?>
<script type="text/javascript">
$(document).ready(function() {
    var timeout = <?php echo $timeout;?>;
    redirect_in_second('countdown', timeout, '<?php echo $url;?>');
});
</script>
    <div class="grid_16">
        <?php
            echo lang('browser_will_be_redirected_to');
            echo nbs(1).anchor($url, $url).nbs(1).lang('in').nbs(1);
        ?>
        <span id="countdown"></span>
        <?php echo nbs(1).lang('seconds'); ?>
        <div class="content-redirect"><?php
            echo isset($content) ? $content : nbs(1);
        ?></div>
    </div>
<?php echo clear_div();?>
