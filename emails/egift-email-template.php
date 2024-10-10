<?php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
    xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title>You've been sent a Gift Card! — Texas de Brazil</title>
        <style type="text/css">
            /* Some resets and issue fixes */

            #outlook a {
                padding: 0;
            }

            body {
                width: 100% !important;
                -webkit-text;
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
                width: 100%;
                !important;
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
        </style>
    </head>
    <body style="padding: 0;margin: 0;background-color: #FFFBF5;-webkit-text: ;size-adjust: 100%;-ms-text-size-adjust: 100%;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;width: 100% !important;">
        <table border="0" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0" width="100%">
            <tr>
                <td align="center" valign="top" style="border-collapse: collapse;">
                    <table width="696" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                        <tr>
                            <td width="48" style="border-collapse: collapse;">&nbsp;</td>
                            <td width="600">
                                <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                    <tr>
                                        <td height="54" style="border-collapse: collapse;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">


                                                <tr>
                                                    <td align="center">

                                                        <?php
                                                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($item->get_meta('theme_id')), 'full');

                                                        if ($image) {
                                                            $card_image = $image[0];
                                                        } else {
                                                            $card_image = get_field('default_ecard_image', 'options');
                                                            $image_url = wp_get_attachment_image_src($card_image, 'full');
                                                            $card_image = $image_url[0];
                                                        }
                                                        ?>
                                                        <img src="<?php echo $card_image; ?>" alt="A gift for you; an eCard from Texas de Brazil!" style="border-radius: 7px; display: block;">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="37" style="border-collapse: collapse;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                                <tr>
                                                    <td align="center">
                                                        <span style="color: #141415; font-size: 32px; line-height: 38px; font-weight: bold;"><?php echo $firstName . ' ' . $lastName; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <span style="color: #8C908E; font-size: 20px; line-height: 32px; font-weight: 300; letter-spacing: 1.5px;">YOU'VE BEEN SENT AN E-GIFT!</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="34" style="border-collapse: collapse;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                                <tr>
                                                    <td width="5.33%"></td>
                                                    <td width="39.34%" style="vertical-align: top;" valign="top">
                                                        <span style="font-size: 15px; line-height: 18px; font-weight: bold; color: #000502;">FROM</span>
                                                        <br>
                                                            <p style="font-size: 15px; line-height: 24px; color: #545d51; margin-top: 17px; margin-bottom: 0;">
                                                                <?php echo get_post_meta($order->get_id(), '_billing_first_name', true) . ' ' . get_post_meta($order->get_id(), '_billing_last_name', true); ?>

                                                                <br> <?php echo get_post_meta($order->get_id(), '_billing_email', true); ?>

                                                            </p>
                                                    </td>
                                                    <td width="39.34%" style="vertical-align: top;" valign="top">
                                                        <span style="font-size: 15px; line-height: 18px; font-weight: bold; color: #000502;"><?php
                                                                if ($message != "")
                                                                    echo 'MESSAGE';
                                                                ?></span>
                                                        <br>
                                                            <p style="font-size: 15px; line-height: 24px; color: #545d51; margin-top: 17px; margin-bottom: 0;">
                                                                <?php echo $message; ?>
                                                            </p>
                                                    </td>
                                                    <td width="5.33%"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php if ($isGiftCard == "Yes"): ?>
                                        <tr>
                                            <td height="37" style="border-collapse: collapse;">&nbsp;</td>
                                        </tr>
                                        <!-- <tr>
                                          <td>
                                            <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                              <tr>
                                                <td width="5.33%"></td>
                                                <td width="39.34%" style="vertical-align: top;" valign="top">
                                                  <span style="font-size: 15px; line-height: 18px; font-weight: bold; color: #000502;">To</span>
                                                  <br>
                                                  <p style="font-size: 15px; line-height: 24px; color: #545d51; margin-top: 17px; margin-bottom: 0;">
                                        <?php echo $firstName . ' ' . $lastName; ?>
                                                    
                                                    <br> <?php echo $user_email; ?>
                                                    
                                                  </p>
                                                </td>
                                                <td width="39.34%" style="vertical-align: top;" valign="top">
                                                  <span style="font-size: 15px; line-height: 18px; font-weight: bold; color: #000502;"><?php
                                        if ($message != "")
                                            echo 'MESSAGE';
                                        ?></span>
                                                  <br>
                                                  <p style="font-size: 15px; line-height: 24px; color: #545d51; margin-top: 17px; margin-bottom: 0;">
    <?php echo $message; ?>
                                                  </p>
                                                </td>
                                                <td width="5.33%"></td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr> -->
<?php endif; ?>
                                    <tr>
                                        <td height="40" style="border-collapse: collapse;">&nbsp;</td>
                                    </tr>
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
                                                                        <tr>
                                                                            <td>
                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                    <tr>
                                                                                        <td width="50%" style="border-collapse: collapse;">
                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                <tr>
                                                                                                    <td width="31" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                    <td style="border-collapse: collapse;">
                                                                                                        <div>
                                                                                                            <span style="color: #FFFFFF; font-size: 20px; line-height: 24px;">E-GIFT CARD NUMBER</span>
                                                                                                        </div>
                                                                                                        <div>
                                                                                                            <span style="color: #8C908E; font-size: 20px; line-height: 24px; text-transform: uppercase;"><?php echo $cardNumber; ?></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                        <td width="25%" style="border-collapse: collapse;">
                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                <tr>
                                                                                                    <td width="31" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                    <td style="border-collapse: collapse;">
                                                                                                        <div>
                                                                                                            <span style="color: #FFFFFF; font-size: 20px; line-height: 24px;">REG CODE</span>
                                                                                                        </div>
                                                                                                        <div>
                                                                                                            <span style="color: #8C908E; font-size: 20px; line-height: 24px; text-transform: uppercase;"><?php echo $regCode; ?></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                        <td width="25%" align="right">
                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                <tr>
                                                                                                    <td>
<?php if ($amount): ?>

                                                                                                            <span style="color: #FFFFFF; font-size: 25px; line-height: 24px; text-transform: uppercase;">$<?php echo $amount; ?></span> <?php else: ?>

                                                                                                            <span style="color: #FFFFFF; font-size: 25px; line-height: 24px; text-transform: uppercase;">$0.00</span> <?php endif; ?>

                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="27" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="1" bgcolor="#313534" style="border-collapse: collapse;"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="46" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $info_image = get_field('egift_informational_image', 'options');
                                                                                $image_url = wp_get_attachment_image_src($info_image, 'full');
                                                                                ?>

                                                                                <img src="<?php echo $image_url[0]; ?>" style="display: block; width: 100%;">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="46" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td height="27" style="border-collapse: collapse;"><a href="<?php echo home_url(); ?>/balance" style="font-size:25px;color: white;display: block;text-align: center;margin: 0px 0px 10px 0;">CHECK BALANCE</a></td>
                                                                        </tr>



                                                                    



                                                                        <tr>
                                                                            <td height="30" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr>
                                                                        <!-- <tr>
                                                                          <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr> -->
                                                                        <tr>
                                                                            <td align="center" style="border-collapse: collapse;">
                                                                                <span style="color: #888888; font-size: 14px; line-height: 18px;"><?php the_field('confirmationcredittext', 'options'); ?></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" style="border-collapse: collapse;">
                                                                                <a href="<?php echo home_url(); ?>/reservations/" style="color: #FFFFFF; font-size: 32px; line-height: 38px; font-weight: bold; text-decoration: none;">RESERVE NOW</a>
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
