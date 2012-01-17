<script type="text/javascript">
</script>
<?php if( ! $error): ?>
<div class="grid_16">
    <p><?php echo lang('order_your_order_has_been_successfully_processed');?>!</p>
    <p><?php
        echo lang('view').' '.lang('your').' '
        .anchor(
            site_url('order/history'),
            lang('order_history')
        ).'.'
    ?></p>
    <p><?php
        echo lang('please').' '
        .anchor(
            site_url('information/contact_us'),
            lang('contact_us')
        ).' '.lang('order_regarding_to_the_payment').'.';
    ?></p>
    <p><?php
        echo lang('thank_you');
    ?></p>
</div>
<?php else: ?>
<div class="grid_16">
    <div class="warning"><?php
        echo nl2br($error);
    ?></div>
    <p><?php
        echo lang('order_due_to_certain_issues_your_order_cannot_be_made')
            .'. '.lang('order_apologize_about_that').'.';
    ?></p>
</div>
<?php endif; ?>
