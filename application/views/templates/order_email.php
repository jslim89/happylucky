<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .hint {
                font-size: 0.9em;
                font-style: italic;
            }
            .order_id {
                font-size: 1.5em;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <p><?php
            echo nl2br("Dear $customer_name, \n");
        ?></p>
        <p><?php
            echo "Your Order has been successfully made."
        ?></p>
        <div id="order_id"><?php
            echo "Order ID: <strong>$order_id</strong>";
        ?></div>
        <table id="product_info" border="1" width="100%">
            <thead>
                <tr>
                    <td class="name"><?php echo lang('product_name');?></td>
                    <td class="quantity"><?php echo lang('cart_quantity');?></td>
                    <td class="price"><?php echo lang('cart_unit_price');?></td>
                    <td class="total"><?php echo lang('cart_total');?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td class="name"><?php echo $item->product->product_name;?></td>
                    <td class="quantity"><?php echo $item->quantity;?></td>
                    <td class="price"><?php echo to_currency($item->unit_sell_price, 'MYR');?></td>
                    <td class="total"><?php echo to_currency($item->subtotal, 'MYR');?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Subtotal: </td>
                    <td><?php echo to_currency($subtotal, 'MYR');?></td>
                </tr>
                <tr>
                    <td colspan="3">Shipping: </td>
                    <td><?php echo to_currency($shipping, 'MYR');?></td>
                </tr>
                <tr>
                    <td colspan="3">Grand Total: </td>
                    <td><?php echo to_currency($grand_total, 'MYR');?></td>
                </tr>
            </tfoot>
        </table>
        <br />
        <hr />
        <p id="shipping_info">
            Delivery Address: <br />
            <?php echo $address; ?>
        </p>
        <hr />
        <p class="hint">
            The product will be delivered within 3 days (Excluding non-working days).
        </p>
        <p id="thank_you">
            Thank You.
        </p>
    </body>
</html>
