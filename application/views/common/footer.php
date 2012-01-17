<?php echo clear_div();?>
<br />

<!-- Footer -->

<div id="footer" class="grid_16">
    <div class="column"><?php
        $info_list = array(
            anchor(
                site_url('information/about_us'),
                lang('about_us')
            ),
            anchor(
                site_url('information/delivery_info'),
                lang('delivery_infomation')
            ),
            anchor(
                site_url('information/privacy_policy'),
                lang('privacy_policy')
            ),
            anchor(
                site_url('information/terms_and_conditions'),
                lang('terms_and_conditions')
            ),
        );
        echo heading(lang('information'), 3);
        echo ul($info_list);
    ?></div>
    <div class="column"><?php
        $service_list = array(
            anchor(
                site_url('information/contact_us'),
                lang('contact_us')
            ),
            anchor(
                site_url('information/ordering'),
                lang('ordering')
            ),
        );
        echo heading(lang('customer_service'), 3);
        echo ul($service_list);
    ?></div>
    <div class="column"><?php
        $my_acc_list = array(
            anchor(
                site_url('user'),
                lang('my_account')
            ),
            anchor(
                site_url('order'),
                lang('order_history')
            ),
        );
        echo heading(lang('my_account'), 3);
        echo ul($my_acc_list);
    ?></div>
</div>

<div class="legal">
    <div class="copyright">
        <div class="licenseInfo">
            &copy; <?php echo lang('all_right_reserved');?>
            <a href=#><?php echo lang('happy_lucky');?></a>
            <br />
        </div>
    </div>
</div>
<!-- End Footer -->

<?php echo clear_div();?>
</div>
<!-- End container_16 -->
</body>
</html>
