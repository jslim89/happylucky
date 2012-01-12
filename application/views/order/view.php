<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
    $('button#back').click(function() {
        redirect(base_url+'order');
    });
    $('#order_form').validationEngine('attach');
});
</script>

<div id="order-content">
    <form id="order_form" method="POST">
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td colspan="2" class="left"><?php
                        echo lang('order_detail');
                    ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" width="50%"><?php
                        echo label(lang('order_invoice_no')).': ';
                        echo 'INV-2012-001';
                        echo br(1);
                        echo label(lang('order_status')).': ';
                        echo lang('order_pending');
                    ?></td>
                    <td class="left"><?php
                        echo label(lang('order_order_date')).': ';
                        echo to_human_date_time(time());
                    ?></td>
                </tr>
            </tbody>
        </table>
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td colspan="2" class="left"><?php
                        echo lang('order_shipping_and_billing_address');
                    ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><?php
                        echo nl2br("Block A-12-10, \nPrima Setapak, \nJalan Genting Klang"
                            .", 53300, \nSetapak, \nKuala Lumpur, \nMalaysia");
                    ?></td>
                </tr>
            </tbody>
        </table>
        <table class="list" width="100%">
            <thead>
                <tr>
                    <td class="left"><?php
                        echo lang('product_code');
                    ?></td>
                    <td class="left"><?php
                        echo lang('product_name');
                    ?></td>
                    <td class="right"><?php
                        echo lang('product_quantity');
                    ?></td>
                    <td class="right"><?php
                        echo lang('product_price');
                    ?></td>
                    <td class="right"><?php
                        echo lang('product_subtotal');
                    ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left"><?php
                        echo 'P001';
                    ?></td>
                    <td class="left"><?php
                        echo 'Product 1';
                    ?></td>
                    <td class="right"><?php
                        echo 5;
                    ?></td>
                    <td class="right"><?php
                        echo to_currency(200, 'MYR');
                    ?></td>
                    <td class="right"><?php
                        echo to_currency(1000, 'MYR');
                    ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="right"><?php
                        echo label(lang('product_subtotal'));
                    ?></td>
                    <td class="right"><?php
                        echo to_currency(1000, 'MYR');
                    ?></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="right"><?php
                        echo label(lang('order_shipping'));
                    ?></td>
                    <td class="right"><?php
                        echo to_currency(20, 'MYR');
                    ?></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="right"><?php
                        echo label(lang('product_grand_total'));
                    ?></td>
                    <td class="right"><?php
                        echo to_currency(1020, 'MYR');
                    ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="buttons">
            <div class="right"><?php
                echo button_link(
                    site_url('order/list'),
                    lang('back')
                );
            ?></div>
        </div>
    </form>
</div>
