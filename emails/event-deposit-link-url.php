<?php
ob_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Event deposit link</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>

            <?php
            echo '<p>Here is your event deposit link to checkout: ' . get_bloginfo('url') . '/automatic-checkout/?amount=' . $_POST['deposit_amount'] . '&token=' . $token . '</p>';

            echo '<ul>';


            foreach ($fields as $key => $val) {
                echo '<li>' . $key . ': <b>' . $val . '</b></li>';
            }
            echo '</ul>';
            ?>
        </div>
    </body>
</html>
<?php
return ob_get_clean();
