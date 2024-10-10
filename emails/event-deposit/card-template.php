<?php ob_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Event Deposit</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Nunito&family=Oswald:wght@500&display=swap');
            body {
                width: 100% !important;
                -webkit-text-size-adjust:100%;
                size-adjust: 100%;
                -ms-text-size-adjust: 100%;
                margin: 0;
                padding: 0;
                background-color: #FFFBF5;
                font-family: 'Nunito', sans-serif;
            }
            h1,h2,h3{
                font-family: 'Oswald', sans-serif;

            }
            .content{
                padding: 25px 50px 10px 50px;
                margin-bottom: 50px;

            }
            @media(max-width:500px){
                .content{
                    padding: 10px 10px;

                }

            }
        </style>

    </head>
    <body>
        <?php if (!empty($showPdfLinks)) include (get_template_directory() . '/emails/partials/email_card_preview.php'); ?>
        <?php if (!empty($showPdfLinks)) { ?>
            <div style="max-width: 600px;text-align: center;margin: 0 auto 15px auto;">
                Print card? <a href="<?php echo home_url(); ?>/reservations/?download_egift_pdf_file=<?php echo $fileUrlName; ?>">Click here</a>
            </div>
        <?php } ?>
        <?php if (!empty($showPdfLink)) { ?>
            <div style="text-align:center;color:#000;">
                Print card? <a href="<?php echo home_url(); ?>/reservations/?generate_egift_card_pdf=<?php echo $id; ?>">Click here</a>
            </div>
        <?php } ?>
        <div style="max-width: 600px;text-align: center;background: black;margin: auto;">
            <img style="width: 100%;" src="<?= get_bloginfo('url'); ?>/assets/img/eDepositCard.jpg">
            <div class="content" style="padding: 25px 20px 10px 20px;">

                <h1 style="color:white;font-size: 40px;margin-top: 0;">Event Deposit Number</h1>
                <p style="background:#86090F;padding: 5px 15px; color:white;margin-bottom: 0px;width: fit-content;margin: auto;font-size: 28px;"><?= $cardNumber ?></p>
                <p style="color:white;margin: 12px 0 0 0;font-size: 24px;">$<?= wc_get_order_item_meta($item_id, 'deposit_amount', true) ?></p>


                <?php
                require_once(get_template_directory() . '/create-bonuscard/barcode.php');
                $printCardNumber = str_replace(' ', '', $cardNumber);
                ?>
                <div style="text-align:center;">

                    <?php
                    $filepath = dirname(__FILE__) . '/barcodes/' . $printCardNumber . '.png';
                    barcode($filepath, $printCardNumber, 70, "horizontal", "code128", false, 1);
                    echo '<img style="width:65%;margin-top:17px;margin-bottom:22px;" class="barcode-image" alt="' . $printCardNumber . '" src="' . get_template_directory_uri() . '/emails/event-deposit/barcodes/' . $printCardNumber . '.png"/>';
                    ?>

                </div>



                <hr style="color:white;"/>
                <a href="<?= get_bloginfo('url') . '/balance'; ?>" style="color:white;text-decoration: underline;font-size: 25px;margin-bottom: 10px;">CHECK BALANCE</a>
                <p style="color:white;font-size: 23px;margin: 5px 0;">REG CODE</p>
                <p style="color:white;font-size: 18px;margin: 5px 0 30px 0;"><?= $regCode ?></p>
                <hr style="color:white;margin: 10px 0;"/>

                <h2 style="color:white;font-size: 36px;">Get ready for your event!</h2>
                <p style="color:white;font-size: 18px;text-align: left;"><?= wc_get_order_item_meta($item_id, 'guest_name', true); ?>, your <?= wc_get_order_item_meta($item_id, 'nature_of_event', true); ?> event at Texas de Brazil - <?= wc_get_order_item_meta($item_id, 'location_name', true); ?> is confirmed! We're looking forward to hosting you on <?= wc_get_order_item_meta($item_id, 'date_event', true); ?>, <?= wc_get_order_item_meta($item_id, 'start_end_time_event', true); ?>, with our <?= wc_get_order_item_meta($item_id, 'package_ordered', true); ?> package for <?= wc_get_order_item_meta($item_id, 'no_of_people', true); ?> guests.</p>
                <p style='color:#8c908e;text-align: left;'>The event deposit number above holds the value of your prepayment required to secure you event booking. We kindly ask that you present the event deposit number to your server or to a manager, like you would a gift card, when you arrive at Texas de Brazil to redeem it's value towards your final bill.</p>
                <hr style="color:white;"/>

                <h3 style="color:white;font-size:22px;">Event Contact Information</h3>
                <p style="color:#8c908e;margin: 4px;">Guest Name: <b style='color:white;margin-bottom: 10px;display: block;'><?= wc_get_order_item_meta($item_id, 'guest_name', true); ?></b></p>
                <p style="color:#8c908e;margin: 4px;">Guest Phone: <b style='color:white;margin-bottom: 10px;display: block;'><?= wc_get_order_item_meta($item_id, 'guest_phone', true); ?></b></p>
                <p style="color:#8c908e;margin: 4px;">Guest Email: <b style='color:white;margin-bottom: 10px;display: block;'><?= wc_get_order_item_meta($item_id, 'guest_email', true); ?></b></p>

                <h3 style="color:white;margin-top: 40px;font-size:22px;">Restaurant Contact Information</h3>
                <p style="color:#8c908e;margin: 4px;">Restaurant Address: <b style='color:white;margin-bottom: 10px;display: block;'><?= wc_get_order_item_meta($item_id, 'location_address', true); ?></b></p>
                <p style="color:#8c908e;margin: 4px;">Restaurant Phone Number: <b style='color:white;margin-bottom: 10px;display: block;'><?= wc_get_order_item_meta($item_id, 'location_phone', true); ?></b></p>
                <p style="color:#8c908e;margin: 4px;">Manager Contact: <b style='color:white;margin-bottom: 10px;display: block;'><?= wc_get_order_item_meta($item_id, 'user_email', true); ?></b></p>
                <a style='display:block;width: fit-content;background:#86090F;color:white;margin: 30px auto;padding: 17px 22px;text-decoration: none;' href="<?= wc_get_order_item_meta($item_id, 'location_website', true); ?>">View More Restaurant Info</a>
                <img style="width: 100%;border-radius: 5px;" src="<?= get_bloginfo('url'); ?>/assets/img/eDepositRestrictions.jpg">
                <p style='color:white;font-size: 12px;'>Thanks for choosing Texas de Brazil!</p>

            </div>


        </div>
    </body>
</html>
<?php
return ob_get_clean();
