<script type="text/javascript">
$(function() {
    $('#btn_view').click(function() {
        $('#view_sales_report').submit();
    });
});
</script>
<div class="grid_16">
    <div class="buttons">
        <form id="view_sales_report" method="POST"
            action="<?php echo site_url('admin/report/sales'); ?>">
            <div class="right"><?php
                echo form_dropdown(
                    'year',
                    Report_Model::get_year_dropdown_list($start_year, $end_year),
                    $selected_year
                );
                echo nbs(2);
                echo button_link(
                    false,
                    lang('view'),
                    array('id' => 'btn_view')
                );
            ?></div>
        </form>
    </div>
    <table class="list">
        <thead>
            <tr>
                <td width="10%"><?php
                    echo lang('report_month');
                ?></td>
                <td width="40%"><?php
                    echo lang('report_products');
                ?></td>
                <td><?php
                    echo lang('report_subtotal');
                ?></td>
                <td><?php
                    echo lang('report_shipping');
                ?></td>
                <td><?php
                    echo lang('report_grand_total');
                ?></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($column_set as $col): ?>
        <tr>
            <td><?php
                echo $col['month'];
            ?></td>
            <td><?php
                $link = array();
                foreach($col['products'] as $product_id => $product) {
                    $text = $product['product_code'].' - '.$product['product_name'];
                    $link[] = anchor(
                        site_url('admin/product/edit/'.$product_id),
                        $text
                    ).' x'.$product['qty_sold'];
                }
                echo nl2br(implode("\n", $link));
            ?></td>
            <td><?php
                echo $col['subtotal'];
            ?></td>
            <td><?php
                echo $col['shipping'];
            ?></td>
            <td><?php
                echo $col['grand_total'];
            ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
