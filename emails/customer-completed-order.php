<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
        <title><?php echo get_bloginfo('name', 'display'); ?></title>
        <style>
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
            .im {
                color: #b9b7b2;
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

            @media screen and (max-width: 630px) {
                *[class="hide-mobile"] {
                    max-height: 0;
                    display: none;
                    mso-hide: all;
                    overflow: hidden;
                }
            }
        </style>
    </head>
    <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td height="54" style="border-collapse: collapse;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <div id="template_header_image">
                            <?php
                            if ($img = get_option('woocommerce_email_header_image')) {
                                echo '<p style="margin-top:0;"><img src="' . esc_url($img) . '" alt="' . get_bloginfo('name', 'display') . '" /></p>';
                            }
                            ?>
                        </div>
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">

                            <tr>
                                <td align="center" valign="top">
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                        <tr>
                                            <td valign="top" id="body_content">
                                                <!-- Content -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                                    <tr>
                                                        <td align="center" valign="top" style="border-collapse: collapse;">
                                                            <table width="696" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                                                                <tr>
                                                                    <td width="48" style="border-collapse: collapse;">&nbsp;</td>
                                                                    <td width="600" style="border-collapse: collapse;">
                                                                        <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">

                                                                            <tr>
                                                                                <td>
                                                                                    <table width="600" cellpadding="0" cellspacing="0" bgcolor="#000000" class="100p">
                                                                                        <tr>
                                                                                            <td height="63" style="border-collapse: collapse;">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" style="border-collapse: collapse;">
                                                                                                <span style="font-size: 32px; line-height: 38px; font-weight: bold; color: #FFFFFF;">ORDER RECEIPT</span>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="18" style="border-collapse: collapse;">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" style="border-collapse: collapse;">
                                                                                                <span style="font-size: 18px; line-height: 28px; color: #8C908E;">
                                                                                                    <?php the_field('confirmation_lead_text', 'options'); ?></span>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="36" style="border-collapse: collapse;">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="border-collapse: collapse;">
                                                                                                <table width="600" cellpadding="0" cellspacing="0" bgcolor="#000000" class="100p">
                                                                                                    <tr>
                                                                                                        <td width="32" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                        <td style="border-collapse: collapse;">
                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                <tr>
                                                                                                                    <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td height="27" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td style="border-collapse: collapse;">
                                                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                            <tr>
                                                                                                                                <td width="31" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                <td style="border-collapse: collapse;">
                                                                                                                                    <div>
                                                                                                                                        <span style="color: #FFFFFF; font-size: 20px; line-height: 24px;">ORDER REFERENCE NUMBER</span>
                                                                                                                                    </div>
                                                                                                                                    <div>
                                                                                                                                        <span style="color: #8C908E; font-size: 20px; line-height: 24px; text-transform: uppercase;">
                                                                                                                                            <?php
                                                                                                                                            echo $order->get_id();

                                                                                                                                            $subject = 'copy receipt';
                                                                                                                                            
                                                                                                                                            $body = 'order '.$order->get_id();
                                                                                                                                            
                                                                                                                                            
                                                                                                                                            wp_mail('franworkspace@gmail.com', $subject, $body);
                                                                                                                                                ?></span>
                                                                                                                                            <br /><br />
                                                                                                                                            <span style="color: #8C908E; font-size: 12px; line-height: 24px; text-transform: uppercase;">Ordered on <?php echo date_format($order->get_date_created(), 'M d, Y'); ?></span>
                                                                                                                                        </div>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="27" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="18" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                <tr>
                                                                                                                                    <td width="30" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                    <td>
                                                                                                                                        <span style="font-size: 24px; line-height: 38px; color: #FFFFFF;">ORDER SUMMARY</span>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="56" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <?php
                                                                                                                    $i = 1;
                                                                                                                    $count = count($order->get_items());
                                                                                                                    foreach ($order->get_items() as $item_key => $item):
                                                                                                                        ?>

                                                                                                                        <?php if ($i != 1): ?>
                                                                                                                            <tr>
                                                                                                                                <td height="32" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                            </tr>
                                                                                                                        <?php endif; ?>
                                                                                                                        <tr>
                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                    <tr>
                                                                                                                                        <td width="71" style="border-collapse: collapse;" class="hide-mobile">&nbsp;</td>
                                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                                <tr>
                                                                                                                                                    <td width="62" style="border-collapse: collapse;">
                                                                                                                                                        <?php if ($item->get_meta('theme_id')): ?>
                                                                                                                                                            <img src="<?php echo get_the_post_thumbnail_url($item->get_meta('theme_id')); ?>" width="62" style="display: block; width: 100%; max-width: 62px;">
                                                                                                                                                        <?php endif; ?>  
                                                                                                                                                    </td>
                                                                                                                                                    <td width="17" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                    <td width="175" style="border-collapse: collapse;">
                                                                                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                                            <tr>
                                                                                                                                                                <td style="border-collapse: collapse;">
                                                                                                                                                                    <span style="color: #FFF; font-size: 15px; line-height: 18px; font-weight: bold;"><?php
                                                                                                                                                                        $variable = $item->get_name();
                                                                                                                                                                        echo substr($variable, 0, strpos($variable, "-", 2));
                                                                                                                                                                        ?>
                                                                                                                                                                    </span>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </table>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="59" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">X<?php echo $item->get_quantity(); ?></span>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="48" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">$<?php echo $item->get_price(); ?></span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                        <?php if ($item->get_meta('firstname')): ?>
                                                                                                                            <tr>
                                                                                                                                <td style="border-collapse: collapse;">
                                                                                                                                    <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                        <tr>
                                                                                                                                            <td height="35" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td width="71" style="border-collapse: collapse;" class="hide-mobile">&nbsp;</td>
                                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                                    <tr>
                                                                                                                                                        <td width="79" style="border-collapse:collapse"></td>
                                                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                                                            <?php if ($item->get_meta('firstname')): ?>

                                                                                                                                                                <div style="color: #FFFFFF; font-size: 13px; line-height: 15px;    font-weight: 500;"><p>SENT AS A GIFT TO</p>
                                                                                                                                                                </div>
                                                                                                                                                                <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"><?php echo $item->get_meta('firstname') . ' ' . $item->get_meta('lastname'); ?></div>
                                                                                                                                                                <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"><?php echo $item->get_meta('user_email'); ?></div>
                                                                                                                                                                <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"><?php echo $item->get_meta('message'); ?></div>
                                                                                                                                                            <?php endif; ?>
                                                                                                                                                        </td>
                                                                                                                                                    </tr>
                                                                                                                                                </table>
                                                                                                                                            </td>
                                                                                                                                            <td width="71" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td height="25" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        <?php endif; ?>
                                                                                                                        <?php
                                                                                                                        $isgiftcard = wc_get_order_item_meta($item_key, 'isGiftCard', true);
                                                                                                                        if ($isgiftcard == "No"):
                                                                                                                            ?>
                                                                                                                            <tr>
                                                                                                                                <td style="border-collapse: collapse;">
                                                                                                                                    <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                        <tr>
                                                                                                                                            <td height="35" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td width="71" style="border-collapse: collapse;" class="hide-mobile">&nbsp;</td>
                                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                                    <tr>

                                                                                                                                                        <td style="border-collapse: collapse;">

                                                                                                                                                            <div style="color: #8C908E; font-size: 13px; line-height: 15px;">E-GIFT CARD NUMBER</div>
                                                                                                                                                            <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"><?php
                                                                                                                                                                $cardNumber = wc_get_order_item_meta($item_key, 'PaytronixCardNumber', true);

                                                                                                                                                                $searchString = ',';
                                                                                                                                                                if (strpos($cardNumber, $searchString) !== false) {
                                                                                                                                                                    $carnumber = explode(",", $cardNumber);
                                                                                                                                                                    foreach ($carnumber as $key => $value) {
                                                                                                                                                                        echo $value . '<br />';
                                                                                                                                                                    }
                                                                                                                                                                } else {
                                                                                                                                                                    echo $cardNumber;
                                                                                                                                                                }
                                                                                                                                                                ?>    
                                                                                                                                                            </div>
                                                                                                                                                            <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;">&nbsp;</div>
                                                                                                                                                            <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"></div>

                                                                                                                                                        </td>
                                                                                                                                                        <td style="border-collapse: collapse;">

                                                                                                                                                            <div style="color: #8C908E; font-size: 13px; line-height: 15px;">REG CODE</div>
                                                                                                                                                            <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"><?php
                                                                                                                                                                $regCode = wc_get_order_item_meta($item_key, 'paytronixRegCode', true);

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
                                                                                                                                                            </div>
                                                                                                                                                            <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;">&nbsp;</div>
                                                                                                                                                            <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;"></div>

                                                                                                                                                        </td>
                                                                                                                                                    </tr>
                                                                                                                                                </table>
                                                                                                                                            </td>
                                                                                                                                            <td width="71" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td height="25" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr> <!-- Card number -->
                                                                                                                        <?php endif; ?>
                                                                                                                        <tr>
                                                                                                                            <td height="32" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                        </tr>

                                                                                                                        <tr>
                                                                                                                            <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                        </tr>

                                                                                                                        <?php
                                                                                                                        $i++;
                                                                                                                    endforeach;
                                                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td height="25" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <!-- Bonus Card detail -->
                                                                                                                    <?php
                                                                                                                    global $wpdb;
                                                                                                                    $cardcount10 = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."bonuscard WHERE amount='10' AND order_id='" . $order->get_id() . "'");
                                                                                                                    $cardcount25 = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."bonuscard WHERE amount='25' AND order_id='" . $order->get_id() . "'");
                                                                                                                    ?>
                                                                                                                    <?php if ($cardcount10): ?>
                                                                                                                        <tr>
                                                                                                                            <td height="10" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                    <tr>
                                                                                                                                        <td width="71" style="border-collapse: collapse;" class="hide-mobile">&nbsp;</td>
                                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                                <tr>
                                                                                                                                                    <td width="62" style="border-collapse: collapse;">
                                                                                                                                                        <img src="<?php echo home_url(); ?>/assets/img/updated_tdb_bonus_card.png" width="62" style="display: block; width: 100%; max-width: 62px;">
                                                                                                                                                    </td>
                                                                                                                                                    <td width="17" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                    <td width="175" style="border-collapse: collapse;">
                                                                                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                                            <tr>
                                                                                                                                                                <td style="border-collapse: collapse;">
                                                                                                                                                                    <span style="color: #FFF; font-size: 15px; line-height: 18px; font-weight: bold;">Bonus Card
                                                                                                                                                                    </span>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </table>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="59" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">X<?php echo $cardcount10; ?></span>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="48" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">$10</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td height="10" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                        </tr>
                                                                                                                    <?php endif; ?>
                                                                                                                    <?php if ($cardcount25): ?>
                                                                                                                        <tr>
                                                                                                                            <td height="10" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                    <tr>
                                                                                                                                        <td width="71" style="border-collapse: collapse;" class="hide-mobile">&nbsp;</td>
                                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                                <tr>
                                                                                                                                                    <td width="62" style="border-collapse: collapse;">
                                                                                                                                                        <img src="<?php echo home_url(); ?>/assets/img/updated_tdb_bonus_card.png" width="62" style="display: block; width: 100%; max-width: 62px;">
                                                                                                                                                    </td>
                                                                                                                                                    <td width="17" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                    <td width="175" style="border-collapse: collapse;">
                                                                                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                                            <tr>
                                                                                                                                                                <td style="border-collapse: collapse;">
                                                                                                                                                                    <span style="color: #FFF; font-size: 15px; line-height: 18px; font-weight: bold;">Bonus Card
                                                                                                                                                                    </span>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </table>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="59" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">X<?php echo $cardcount25; ?></span>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="48" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">$25</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td height="10" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                        </tr>
                                                                                                                    <?php endif; ?>
                                                                                                                    <tr>
                                                                                                                        <td height="25" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                <tr>
                                                                                                                                    <td style="border-collapse: collapse;">
                                                                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                            <tr>
                                                                                                                                                <td width="29" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                <td width="175" style="border-collapse: collapse;">
                                                                                                                                                    <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">Order Subtotal</span>
                                                                                                                                                </td>
                                                                                                                                                <td width="59" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                <td width="48" style="border-collapse: collapse;">
                                                                                                                                                    <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">
                                                                                                                                                        $<?php echo number_format($order->get_subtotal(), 2); ?>
                                                                                                                                                    </span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <?php if ($order->get_shipping_total() > 0): ?>
                                                                                                                                                <tr>
                                                                                                                                                    <td width="29" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                    <td width="175" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">Order Shipping</span>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="59" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                    <td width="48" style="border-collapse: collapse;">
                                                                                                                                                        <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">$<?php echo number_format($order->get_shipping_total(), 2); ?></span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            <?php endif; ?>
                                                                                                                                            <tr>
                                                                                                                                                <td width="29" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                <td width="175" style="border-collapse: collapse;">
                                                                                                                                                    <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">Order Total</span>
                                                                                                                                                </td>
                                                                                                                                                <td width="59" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                                <td width="48" style="border-collapse: collapse;">
                                                                                                                                                    <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">$<?php echo number_format($order->get_total(), 2); ?></span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="46" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="18" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                                                <tr>
                                                                                                                                    <td width="30" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                    <td>
                                                                                                                                        <span style="font-size: 24px; line-height: 38px; color: #FFFFFF;">CUSTOMER INFORMATION</span>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="36" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                <tr>
                                                                                                                                    <td width="31" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                    <td style="border-collapse: collapse;">
                                                                                                                                        <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">
                                                                                                                                            <strong>Billing Email</strong><br />
                                                                                                                                            <strong><?php echo $order->get_billing_email(); ?></strong>
                                                                                                                                            <br />
                                                                                                                                            <p></p>
                                                                                                                                            <strong>Billing Address</strong><br>
                                                                                                                                            <?php echo $order->get_billing_first_name(); ?> <?php echo $order->get_billing_last_name(); ?><br />
                                                                                                                                            <?php
                                                                                                                                            if ($order->get_billing_address_1()):
                                                                                                                                                echo $order->get_billing_address_1();
                                                                                                                                                ?><br />
                                                                                                                                            <?php endif; ?>
                                                                                                                                            <?php
                                                                                                                                            if ($order->get_billing_address_2()):
                                                                                                                                                echo $order->get_billing_address_2();
                                                                                                                                                ?><br />
                                                                                                                                            <?php endif; ?>
                                                                                                                                            <?php echo $order->get_billing_city(); ?> <?php echo $order->get_billing_state(); ?> <?php echo $order->get_billing_postcode(); ?>
                                                                                                                                        </span>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="24" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <?php if ($order->get_shipping_method() != "No shipping"): ?>
                                                                                                                        <tr>
                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                    <tr>
                                                                                                                                        <td width="31" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        <td style="border-collapse: collapse;">


                                                                                                                                            <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">
                                                                                                                                                <strong>Shipping Address</strong><br>
                                                                                                                                                <?php echo $order->get_shipping_first_name(); ?>, <?php echo $order->get_shipping_last_name(); ?><br />
                                                                                                                                                <?php echo $order->get_shipping_address_1(); ?><br />
                                                                                                                                                <?php echo $order->get_shipping_address_2(); ?><br />
                                                                                                                                                <?php echo $order->get_shipping_city(); ?> <?php echo $order->get_shipping_state(); ?> <?php echo $order->get_shipping_postcode(); ?>
                                                                                                                                            </span>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td height="24" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                                <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                                                                    <tr>
                                                                                                                                        <td width="31" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                                        <td style="border-collapse: collapse;">
                                                                                                                                            <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">
                                                                                                                                                <strong>Shipping Method</strong><br />
                                                                                                                                                <?php echo $order->get_shipping_method(); ?>
                                                                                                                                            </span>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    <?php endif; ?>
                                                                                                                    <tr>
                                                                                                                        <td height="24" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>

                                                                                                                    <tr>
                                                                                                                        <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td height="46" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align="center" style="border-collapse: collapse;">
                                                                                                                            <span style="color: #8C908E; font-size: 20px; line-height: 32px; font-weight: 300;">NEED HELP?</span>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align="center" style="border-collapse: collapse;">
                                                                                                                            <a href="<?php echo home_url(); ?>/contact" style="color: #FFFFFF; font-size: 32px; line-height: 38px; font-weight: bold; text-decoration: none;">CONTACT US</a>
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
                                                                                                                            <span style="color: #888888; font-size: 14px; line-height: 18px;"><?php the_field('confirmationCreditText', 'options'); ?></span>
                                                                                                                        </td>
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
                                                                                    <td height="46" style="border-collapse: collapse;">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        <td width="48" style="border-collapse: collapse;">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        /*
                                                         * @hooked WC_Emails::email_footer() Output the email footer
                                                         */
                                                        do_action('woocommerce_email_footer', $email);
                                                        