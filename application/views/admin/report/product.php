<script type="text/javascript">
$(function() {
    $('#btn_view').click(function() {
        $('#view_product_report').submit();
    });
});
</script>
<div class="grid_16">
    <div class="buttons">
        <form id="view_product_report" method="POST"
            action="<?php echo site_url('admin/report/product'); ?>">
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
                <td><?php
                    echo lang('report_product');
                ?></td>
                <?php foreach(Report_Model::get_month_dropdown_list() as $k => $v): ?>
                <td><?php
                    echo $v;
                ?></td>
                <?php endforeach; ?>
                <td><?php
                    echo lang('report_total');
                ?></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach($column_set as $col): ?>
        <tr>
            <td><?php
                echo anchor(
                    site_url('admin/product/edit/'.$col['product_id']),
                    $col['product']
                );
            ?></td>
            <td><?php
                echo $col['january'];
            ?></td>
            <td><?php
                echo $col['february'];
            ?></td>
            <td><?php
                echo $col['march'];
            ?></td>
            <td><?php
                echo $col['april'];
            ?></td>
            <td><?php
                echo $col['may'];
            ?></td>
            <td><?php
                echo $col['june'];
            ?></td>
            <td><?php
                echo $col['july'];
            ?></td>
            <td><?php
                echo $col['august'];
            ?></td>
            <td><?php
                echo $col['september'];
            ?></td>
            <td><?php
                echo $col['october'];
            ?></td>
            <td><?php
                echo $col['november'];
            ?></td>
            <td><?php
                echo $col['december'];
            ?></td>
            <td><?php
                echo $col['total'];
            ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
