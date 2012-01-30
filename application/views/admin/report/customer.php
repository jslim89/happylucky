<script type="text/javascript">
$(function() {
    $('#btn_view').click(function() {
        $('#view_customer_report').submit();
    });

    $('#btn_to_excel').click(function() {
        redirect(base_url + 'admin/report/export_customer/<?php echo $selected_year; ?>');
    });
});
</script>
<div class="grid_16">
    <div class="buttons">
        <form id="view_customer_report" method="POST"
            action="<?php echo site_url('admin/report/customer'); ?>">
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
                echo anchor(
                    site_url('admin/customer/edit/'.$col['customer_id']),
                    $col['customer']
                );
            ?></td>
            <td><?php
                echo to_currency($col['january']);
            ?></td>
            <td><?php
                echo to_currency($col['february']);
            ?></td>
            <td><?php
                echo to_currency($col['march']);
            ?></td>
            <td><?php
                echo to_currency($col['april']);
            ?></td>
            <td><?php
                echo to_currency($col['may']);
            ?></td>
            <td><?php
                echo to_currency($col['june']);
            ?></td>
            <td><?php
                echo to_currency($col['july']);
            ?></td>
            <td><?php
                echo to_currency($col['august']);
            ?></td>
            <td><?php
                echo to_currency($col['september']);
            ?></td>
            <td><?php
                echo to_currency($col['october']);
            ?></td>
            <td><?php
                echo to_currency($col['november']);
            ?></td>
            <td><?php
                echo to_currency($col['december']);
            ?></td>
            <td><?php
                echo to_currency($col['total']);
            ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
