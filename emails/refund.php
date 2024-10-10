{% set emails = craft.globals.getSetByHandle('emails') %}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">

    <title>Refund Confirmation — Texas de Brazil</title>

    <style type="text/css">
        /* Some resets and issue fixes */
        #outlook a { padding:0; }
        body{ width:100% !important; -webkit-text; size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; background-color: #FFFBF5; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        .ReadMsgBody { width: 100%; }
        .ExternalClass {width:100%; }
        .backgroundTable { margin:0 auto; padding:0; width:100%;!important; }
        table td { border-collapse: collapse; }
        .ExternalClass * { line-height: 115%; }
        /* End reset */

        @media screen and (max-width: 630px) {
            *[class="mobile-column"] { display: block; }
            *[class="mob-column"] { float: none !important;width: 100% !important; }
            *[class="hide"] { display:none !important; }
            *[class="100p"] { width:100% !important; height:auto !important; }
            *[class="condensed"] { padding-bottom:40px !important; display: block; }
            *[class="center"] { text-align:center !important; width:100% !important; height:auto !important; }
            *[class="100pad"] { width:100% !important; padding:20px; }
            *[class="100padleftright"] { width:100% !important; padding:0 20px 0 20px; }
            *[class="100padtopbottom"] { width:100% !important; padding:20px 0px 20px 0px; }
        }

        @media screen and (max-width: 630px) {
            *[class="hide-mobile"] { max-height: 0; display: none; mso-hide: all; overflow: hidden; }
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
                    <td width="600" style="border-collapse: collapse;">
                        <table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFBF5" class="100p">
                            <tr>
                                <td height="54" style="border-collapse: collapse;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" style="border-collapse: collapse;">
                                    <img src="{{ siteUrl }}assets/img/logo-alt-retina.png" width="219" height="72">
                                </td>
                            </tr>
                            <tr>
                                <td height="46" style="border-collapse: collapse;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="600" cellpadding="0" cellspacing="0" bgcolor="#000000" class="100p">
                                        <tr>
                                            <td height="63" style="border-collapse: collapse;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="border-collapse: collapse;">
                                                <span style="font-size: 32px; line-height: 38px; font-weight: bold; color: #FFFFFF;">REFUND CONFIRMATION</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="18" style="border-collapse: collapse;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="border-collapse: collapse;">
                                                <span style="font-size: 18px; line-height: 28px; color: #8C908E;">{{ emails.leadText }}</span>
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
                                                                                        <span style="color: #8C908E; font-size: 20px; line-height: 24px; text-transform: uppercase;">{{ order.shortNumber }}</span>
                                                                                        <br /><br />
                                                                                        <span style="color: #8C908E; font-size: 12px; line-height: 24px; text-transform: uppercase;">Your Refund of <strong>{{ order.totalPaid|currency('USD') }}</strong> for Order #{{ order.shortNumber }} has been completed successfully.</span>
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
                                                                {% for item in order.lineItems %}
                                                                    {% set product = item.purchasable %}

                                                                    {% if not loop.first %}
                                                                    <tr>
                                                                        <td height="32" style="border-collapse: collapse;">&nbsp;</td>
                                                                    </tr>
                                                                    {% endif %}
                                                                    <tr>
                                                                        <td style="border-collapse: collapse;">
                                                                            <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                <tr>
                                                                                    <td width="71" style="border-collapse: collapse;" class="hide-mobile">&nbsp;</td>
                                                                                    <td style="border-collapse: collapse;">
                                                                                        <table cellpadding="0" cellspacing="0" bgcolor="#000000" width="100%">
                                                                                            <tr>
                                                                                                <td width="62" style="border-collapse: collapse;">
                                                                                                    {% if item.options.themeId is defined %}
                                                                                                        {% set asset = craft.entries.section('themes').id(item.options.themeId).first.themeImage %}

                                                                                                        <img src="{{ asset.first.url }}" width="62" style="display: block; width: 100%; max-width: 62px;">
                                                                                                    {% else %}
                                                                                                        <img src="{{ product.product.productPhoto.first.url }}" width="62" style="display: block; width: 100%; max-width: 62px;">
                                                                                                    {% endif %}
                                                                                                </td>
                                                                                                <td width="17" style="border-collapse: collapse;">&nbsp;</td>
                                                                                                <td width="175" style="border-collapse: collapse;">
                                                                                                    <table cellpadding="0" cellspacing="0" bgcolor="#000000">
                                                                                                        <tr>
                                                                                                            <td style="border-collapse: collapse;">
                                                                                                                <span style="color: #FFF; font-size: 15px; line-height: 18px; font-weight: bold;">{{ product.title }}</span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td width="59" style="border-collapse: collapse;">
                                                                                                    <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">X{{ item.qty }}</span>
                                                                                                </td>
                                                                                                <td width="48" style="border-collapse: collapse;">
                                                                                                    <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">{{ item.subtotal|currency('USD') }}</span>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
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
                                                                                                <td width="79" style="border-collapse: collapse;" class="hide-mobile"></td>
                                                                                                <td style="border-collapse: collapse;">
                                                                                                    {% if item.options.firstName|default %}
                                                                                                        <div style="color: #8C908E; font-size: 13px; line-height: 15px;">RECIPIENT</div>
                                                                                                        <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;">{{ item.options.firstName|default }} {{ item.options.lastName|default }}</div>
                                                                                                        <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;">{{ item.options.email|default }}</div>
                                                                                                        <div style="color: #B9B7B2; font-size: 15px; line-height: 24px;">{{ item.options.message|default }}</div>
                                                                                                    {% endif %}
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
                                                                    {% if not loop.last %}
                                                                        <tr>
                                                                            <td height="1" bgcolor="#151917" style="border-collapse: collapse;"></td>
                                                                        </tr>
                                                                    {% endif %}
                                                                {% endfor %}
                                                                <tr>
                                                                    <td height="25" style="border-collapse: collapse;">&nbsp;</td>
                                                                </tr>
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
                                                                                                <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">{{ order.itemSubtotal|currency('USD') }}</span>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="29" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            <td width="175" style="border-collapse: collapse;">
                                                                                                <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">Order Shipping</span>
                                                                                            </td>
                                                                                            <td width="59" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            <td width="48" style="border-collapse: collapse;">
                                                                                                <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">{{ order.totalShippingCost|currency('USD') }}</span>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="29" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            <td width="175" style="border-collapse: collapse;">
                                                                                                <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">Order Total</span>
                                                                                            </td>
                                                                                            <td width="59" style="border-collapse: collapse;">&nbsp;</td>
                                                                                            <td width="48" style="border-collapse: collapse;">
                                                                                                <span style="color: #FCFBFA; font-size: 20px; line-height: 24px; font-weight: 300;">{{ order.totalPaid|currency('USD') }}</span>
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
                                                                                    {% set address = order.billingAddress %}

                                                                                    <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">
                                                                                        <strong>Billing Address</strong><br>
                                                                                        {{ address.firstName }}, {{ address.lastName }}<br />
                                                                                        {{ address.address1 }}<br />
                                                                                        {% if address.address2 %}{{ address.address2 }}<br />{% endif %}
                                                                                        {{ address.city }} {{ address.state }} {{ address.zipCode }}
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
                                                                                    {% set address = order.shippingAddress %}

                                                                                    <span style="color: #B9B7B2; font-size: 15px; line-height: 24px;">
                                                                                        <strong>Shipping Address</strong><br>
                                                                                        {{ address.firstName }}, {{ address.lastName }}<br />
                                                                                        {{ address.address1 }}<br />
                                                                                        {% if address.address2 %}{{ address.address2 }}<br />{% endif %}
                                                                                        {{ address.city }} {{ address.state }} {{ address.zipCode }}
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
                                                                                        {% set method = order.getShippingMethod() %}

                                                                                        <strong>Shipping Method</strong><br />
                                                                                        {{ method.name|default }}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                {% set transaction = order.getTransactions[0] %}
                                                                {% set response = craft.texas.decode(transaction.reference) %}
                                                                {% if response | length %}
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
                                                                                            <strong>Payment Method</strong><br />
                                                                                            Card ending in {{ response.card.number }} &mdash; {{ order.totalPaid|currency('USD') }}
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                {% endif %}
                                                                <tr>
                                                                    <td height="48" style="border-collapse: collapse;">&nbsp;</td>
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
                                                                        <a href="{{ siteUrl }}/contact" style="color: #FFFFFF; font-size: 32px; line-height: 38px; font-weight: bold; text-decoration: none;">CONTACT US</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="50" style="border-collapse: collapse;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="15" style="border-collapse: collapse;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" style="border-collapse: collapse;">
                                                                        <span style="color: #888888; font-size: 14px; line-height: 18px;">{{ emails.confirmationCreditText }}</span>
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
</table>

</body>
</html>