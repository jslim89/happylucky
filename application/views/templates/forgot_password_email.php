<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .hint {
                font-size: 0.9em;
                font-style: italic;
            }
            div#password {
                color: red;
            }
            span#new_passwd {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <p><?php
            echo nl2br("Dear $customer_name, \n");
        ?></p>
        <p><?php
            echo "A new password is generated for your account."
        ?></p>
        <div id="password">
            New Password: <span id="new_passwd"><?php echo $password; ?></span>
        </div>
        <hr />
        <p><?php
            echo "Please ".anchor(site_url('user/login'), 'Login')
            ." your account with the new password and change your
            password immediately.";
        ?></p>
        <div id="thank_you">
            Thank You.
        </div>
    </body>
</html>
