<script type="text/javascript">
</script>
<?php if( ! $error): ?>
<div class="grid_16">
    <div class="success"><?php echo lang('order_your_order_has_been_successfully_processed');?>!</div>
    <p>
        <h2><?php
            echo lang('order_your_order_id_is').' '
            .span($order->id, array(
                'style' => 'color: red; font-size: 1.5em;'
            ));
        ?></h2>
        <div class="hint"><?php
            echo lang('order_order_id_remark');
        ?></div>
    </p>
    <p><?php
        echo lang('view').' '.lang('your').' '
        .anchor(
            site_url('order'),
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
        echo lang('please_check_your_mailbox').'. ';
        echo lang('thank_you');
    ?></p>
</div>
<?php else: ?>
<div class="grid_16">
    <div class="warning"><?php
        echo nl2br($error);
    ?></div>
    <p><?php
        echo lang('order_not_enough_quantity_message')
            .' '.lang('order_apologize_about_that').'.';
    ?></p>
</div>
<?php endif; ?>
