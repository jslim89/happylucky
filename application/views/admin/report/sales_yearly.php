<script type="text/javascript">
$(function() {
    $('#btn_view').click(function() {
        $('#view_sales_report').submit();
    });

    $('#btn_to_excel').click(function() {
        redirect(base_url + 'admin/report/export_sales_yearly/<?php echo $selected_year; ?>');
    });
});
</script>
<div class="grid_16">
    <div class="buttons">
        <form id="view_sales_report" method="POST"
            action="<?php echo site_url('admin/report/sales_yearly'); ?>">
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
            <div class="left"><?php
                echo button_link(
                    false,
                    lang('report_export_to_excel'),
                    array('id' => 'btn_to_excel')
                );
            ?></div>
        </form>
    </div>
    <table class="list">
        <thead>
            <tr>
            <?php foreach($header_set as $header): ?>
                <td><?php
                    echo $header;
                ?></td>
            <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($column_set as $col): ?>
            <tr>
                <td><?php
                    echo $col['month'];
                ?></td>
                <td><?php
                    echo $col['revenue'];
                ?></td>
                <td><?php
                    echo $col['cost'];
                ?></td>
                <td><?php
                    echo $col['profit'];
                ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold;">
            <?php foreach($total_set as $col): ?>
                <td><?php
                    echo $col;
                ?></td>
            <?php endforeach; ?>
            </tr>
        </tfoot>
    </table>
</div>
