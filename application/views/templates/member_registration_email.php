<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .hint {
                font-size: 0.9em;
                font-style: italic;
            }
        </style>
    </head>
    <body>
        <p><?php
            echo nl2br("Dear $customer_name, \n");
        ?></p>
        <p><?php
            echo "Your account has been successfully registered.";
            echo br(1)."Please click on the link below for account verification.";
        ?></p>
        <hr />
        <div id="link"><?php
            echo anchor(
                $url,
                $url
            );
        ?></div>
        <hr />
        <div id="thank_you">
            Thank You.
        </div>
    </body>
</html>
