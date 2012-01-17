<div class="grid_16">
    <div class="box">
        <div class="box-heading"><?php
            echo lang('our_location');
        ?></div>
        <div class="box-content">
            <table width="100%">
                <thead>
                    <tr>
                        <td width="50%"><?php
                            echo lang('address');
                        ?></td>
                        <td width="50%"><?php
                            echo lang('contact');
                        ?></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="50%">
                        Jalan testing, 12345, Kuala Lumpur, Malaysia.
                        </td>
                        <td width="50%"><?php
                            echo lang('home').': 03-87654321';
                            echo br(1);
                            echo lang('tel').': 012-3456789';
                            echo br(1);
                            echo lang('fax').': 03-12345678';
                            echo br(1);
                            echo span(
                                lang('please_do_not_hesitate_to_call_us_if_you_have_any_questions'),
                                array('class' => 'hint')
                            );
                        ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
