<?php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
    xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="format-detection" content="telephone=no">
                <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
                    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
                        <title>You've been sent a Gift Card! — Texas de Brazil</title>
                        <style type="text/css">
                            /* Some resets and issue fixes */

                            #outlook a {
                                padding: 0;
                            }

                            body {
                                width: 100% !important;
                                -webkit-text-size-adjust:100%;
                                size-adjust: 100%;
                                -ms-text-size-adjust: 100%;
                                margin: 0;
                                padding: 0;
                                background-color: #FFFBF5;
                                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                            }

                            .ReadMsgBody {
                                width: 100%;
                            }

                            .ExternalClass {
                                width: 100%;
                            }

                            .backgroundTable {
                                margin: 0 auto;
                                padding: 0;
                                width: 100% !important;
                            }

                            table td {
                                border-collapse: collapse;
                            }

                            .ExternalClass * {
                                line-height: 115%;
                            }
                            /* End reset */

                            @media screen and (max-width: 630px) {
                                *[class="mobile-column"] {
                                    display: block;
                                }
                                *[class="mob-column"] {
                                    float: none !important;
                                    width: 100% !important;
                                }
                                *[class="hide"] {
                                    display: none !important;
                                }
                                *[class="100p"] {
                                    width: 100% !important;
                                    height: auto !important;
                                }
                                *[class="condensed"] {
                                    padding-bottom: 40px !important;
                                    display: block;
                                }
                                *[class="center"] {
                                    text-align: center !important;
                                    width: 100% !important;
                                    height: auto !important;
                                }
                                *[class="100pad"] {
                                    width: 100% !important;
                                    padding: 20px;
                                }
                                *[class="100padleftright"] {
                                    width: 100% !important;
                                    padding: 0 20px 0 20px;
                                }
                                *[class="100padtopbottom"] {
                                    width: 100% !important;
                                    padding: 20px 0px 20px 0px;
                                }
                            }
                            .barcode-image{
                                margin-top: 18px;
                                border-radius: 3px;
                                width:65%;min-width:350px;
                            }
                        </style>
                        </head>
                        <body style="padding: 0;margin: 0;background-color: #FFFBF5;-webkit-text-size-adjust:100%;size-adjust: 100%;-ms-text-size-adjust: 100%;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;width: 100% !important;">
                            <?php if (!empty($showPdfLinks)) require_once (get_template_directory() . '/emails/partials/email_card_preview.php'); ?>
                            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0" width="100%">
                                <tr>
                                    <td align="center" valign="top" style="border-collapse: collapse;">
                                        <table width="696" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                            <tr>
                                                <td width="48" style="border-collapse: collapse;">&nbsp;</td>
                                                <td width="600">
                                                    <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                                        <tr>
                                                            <td height="30" style="border-collapse: collapse;">
                                                                <?php if (!empty($showPdfLinks)) { ?>
                                                                    <div style="text-align:center;color:#000;">
                                                                        Print card? <a href="<?php echo home_url(); ?>/reservations/?download_egift_pdf_file=<?php echo $fileUrlName; ?>">Click here</a>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if (!empty($showPdfLink)) { ?>
                                                                    <div style="text-align:center;color:#000;">
                                                                        Print card? <a href="<?php echo home_url(); ?>/reservations/?generate_egift_card_pdf=<?php echo $id; ?>">Click here</a>
                                                                    </div>
                                                                <?php } ?>


                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">


                                                                    <tr>
                                                                        <td align="center">
                                                                            <?php
                                                                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($this->themeId), 'full');
                                                                            if ($image) {
                                                                                $card_image = $image[0];
                                                                            } else {
                                                                                $card_image = get_field('default_ecard_image', 'options');
                                                                                $image_url = wp_get_attachment_image_src($card_image, 'full');
                                                                                $card_image = $image_url[0];
                                                                            }
                                                                            ?>
                                                                            <img src="<?= $card_image; ?>" data-img="" alt="A gift for you; an eCard from Texas de Brazil!" style="border-radius: 7px; display: block;width: 80%;">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="37" style="border-collapse: collapse;">&nbsp;</td>
                                                        </tr>



                                                        <?php if ($this->isGiftedCard): ?>

                                                            <tr>
                                                                <td>
                                                                    <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <span style="color: #141415; font-size: 32px; line-height: 38px; font-weight: bold;"><?= $this->giftedName; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <span style="color: #8C908E; font-size: 20px; line-height: 32px; font-weight: 300; letter-spacing: 1.5px;">YOU'VE BEEN SENT AN E-GIFT!</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <span style="color: #8C908E; font-size: 20px; line-height: 32px; font-weight: 300; letter-spacing: 1.5px;">From: <?= $this->giftedName; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <span style="color: #000; font-size: 20px; line-height: 32px; font-weight: 300; letter-spacing: 1.5px;padding-top: 15px;display: block;"><?= $this->giftedMessage; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="34" style="border-collapse: collapse;">&nbsp;</td>
                                                            </tr>

                                                        <?php endif; ?>




                                                        <tr>
                                                            <td>
                                                                <table width="600" cellpadding="0" cellspacing="0" bgcolor="#000000" class="100p">
                                                                    <tr>
                                                                        <td style="border-collapse: collapse;">


                                                                            <table width="600" cellpadding="0" cellspacing="0" bgcolor="#000000" class="100p">
                                                                                <tr>
                                                                                    <td width="32" style="border-collapse: collapse;">&nbsp;</td>
                                                                                    <td style="border-collapse: collapse;">





                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                            <tr>
                                                                                                <td height="1" bgcolor="#313534" style="border-collapse: collapse;"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="27" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>



                                                                                            <tr style="text-align:center;">


                                                                                                <td>

                                                                                                    <div>
                                                                                                        <span style="color: #FFFFFF; font-size: 25px; line-height: 24px;text-align:center;">E-CARD NUMBER</span>
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <span style="color: #8C908E; font-size: 25px; line-height: 24px; text-transform: uppercase;text-align:center;display: block;padding-bottom: 8px;padding-top: 15px;">
                                                                                                            <?php
                                                                                                            //echo $cardNumber;
                                                                                                            $cardNumberSingle = false;
                                                                                                            $searchString = ',';
                                                                                                            if (strpos($cardNumber, $searchString) !== false) {
                                                                                                                $cardNumber = explode(",", $cardNumber);
                                                                                                                foreach ($cardNumber as $key => $value) {
                                                                                                                    echo $value . '<br />';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo $cardNumber;
                                                                                                                $cardNumberSingle = true;
                                                                                                            }
                                                                                                            ?> 
                                                                                                        </span>
                                                                                                    </div>




                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="text-align:center;">

                                                                                                <td>



                                                                                                    <?php if ($amount): ?>

                                                                                                        <span style="color: #FFFFFF; font-size: 20px; line-height: 24px; text-transform: uppercase;text-align:center;" >$<?= $amount; ?></span> 
                                                                                                    <?php else: ?>

                                                                                                        <span style="color: #FFFFFF; font-size: 20px; line-height: 24px; text-transform: uppercase;text-align:center;" >$0.00</span> 
                                                                                                    <?php endif; ?>



                                                                                                </td>


                                                                                            </tr>

                                                                                            <?php
                                                                                            if ($cardNumberSingle && $cardNumber && true) {
                                                                                                require_once(get_template_directory() . '/create-bonuscard/barcode.php');
                                                                                                $printCardNumber = str_replace(' ', '', $cardNumber);
                                                                                                ?>
                                                                                                <tr style="text-align:center;">
                                                                                                    <td>
                                                                                                        <?php
                                                                                                        $filepath = get_template_directory() . '/create-bonuscard/barcodes/' . $printCardNumber . '.png';
                                                                                                        barcode($filepath, $printCardNumber, 70, "horizontal", "code128", false, 1);
                                                                                                        echo '<img style="width:65%;min-width:350px;margin-top:40px;" class="barcode-image" alt="' . $printCardNumber . '" src="' . get_template_directory_uri() . '/create-bonuscard/barcodes/' . $printCardNumber . '.png"/>';
                                                                                                        ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <?php } ?>








                                                                                            <tr>
                                                                                                <td height="27" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>


                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    $info_image = get_field('egift_informational_image', 'options');
                                                                                                    if ($info_image) {
                                                                                                        $image_url = wp_get_attachment_image_src($info_image, 'full');
                                                                                                        if (!empty($image_url[0])) {
                                                                                                            ?>

                                                                                                            <img src="<?= $image_url[0]; ?>" style="display: block; width: 100%;">
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                </td>
                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td height="15" style="border-collapse: collapse;"><hr/></td>
                                                                                            </tr>


                                                                                            <tr>
                                                                                                <td height="20" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="27" style="border-collapse: collapse;"><a href="<?= home_url(); ?>/balance" style="font-size:25px;color: white;display: block;text-align: center;margin: 0px 0px 10px 0;">CHECK BALANCE</a></td>
                                                                                            </tr>


                                                                                            <tr>
                                                                                                <td style="border-collapse: collapse;text-align:center;">

                                                                                                    <table cellpadding="0" cellspacing="0" bgcolor="#000000" style="margin:auto;">
                                                                                                        <tr>

                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                <div>
                                                                                                                    <span style="color: #FFFFFF; font-size: 20px; line-height: 24px;">REG CODE</span>
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    <span style="color: #8C908E; font-size: 20px; line-height: 24px; text-transform: uppercase;">
                                                                                                                        <?php
                                                                                                                        $searchString = ',';
                                                                                                                        if (strpos($regCode, $searchString) !== false) {
                                                                                                                            $regcode = explode(",", $regCode);
                                                                                                                            foreach ($regcode as $key => $value) {
                                                                                                                                echo $value . '<br />';
                                                                                                                            }
                                                                                                                        } else {
                                                                                                                            echo $regCode;
                                                                                                                        }
                                                                                                                        ?>  
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>


                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td><div style="padding:10px;text-align: center;color:white;font-size: 20px; line-height: 24px;">Must present this card, in its original format, to redeem as payment</div></td>
                                                                                            </tr>



                                                                                            <tr>
                                                                                                <td style="text-align:center;">



                                                                                                    <a href="https://texasdebrazil.com/wp-content/uploads/2024/03/eGift-Card-Restrictions.jpg" target="blank">
                                                                                                        <img src="https://texasdebrazil.com/wp-content/uploads/2024/03/eGift-Card-Restrictions.jpg" style="display: block; max-width: 98%;margin:auto;border-radius: 8px;">
                                                                                                    </a>

                                                                                                </td>
                                                                                            </tr>


                                                                                            <tr>
                                                                                                <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="center" style="border-collapse: collapse;">
                                                                                                    <span style="color: #888888; font-size: 14px; line-height: 18px;"><?php the_field('confirmationCreditText', 'options'); ?></span>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td align="center" style="border-collapse: collapse;">
                                                                                                    <a href="<?= home_url(); ?>/reservations/" style="color: #FFFFFF; font-size: 32px; line-height: 38px; font-weight: bold; text-decoration: none;">RESERVE NOW</a>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                    <td width="32" style="border-collapse: collapse;">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="40" style="border-collapse: collapse;">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="48" style="border-collapse: collapse;">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>
                        </html>
                        <?php
                        return ob_get_clean();
                        