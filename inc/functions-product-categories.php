<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//add_filter('woocommerce_package_rates', 'woocommerce_package_rates');

function woocommerce_package_rates($rates) {
    //var_dump($rates);
    foreach ($rates as $key => $rate) {
        $rates[$key]->cost = 10;
    }

    return $rates;
}

//add_action('woocommerce_after_checkout_validation', 'woocommerce_after_checkout_validation_callback', 10, 2);

function tx_is_category($category = 'gift_cards', $products_id = NULL) {
    $current_categories = [];
    if (!$products_id) {
        if ($current_categories = get_queried_object())
            $current_categories = $current_categories->term_id;
    } else {
        foreach ((array) $products_id as $id)
            $current_categories = array_unique(array_merge($current_categories, wp_get_post_terms($id, 'product_cat', array('fields' => 'ids'))));
    }
    //var_dump($current_categories);
    foreach ((array) $current_categories as $current_category)
        switch ($category) {
            case 'gift_cards':
                return CATEGORY_GIFT_CARDS == $current_category;
                break;
            case 'a_la_carte':
                return CATEGORY_A_LA_CARTE == $current_category;
                break;
            case 'packages':
                return CATEGORY_PACKAGES == $current_category;
                break;
            case 'merch':
                return CATEGORY_MERCHANDISE == $current_category;
                break;
        }
    return false;
}

function tx_get_total_meet_price() {
    $total_meet_amount = 0;
    foreach (WC()->cart->get_cart_contents() as $item) {


        if (has_term(array(CATEGORY_PACKAGES, CATEGORY_A_LA_CARTE), 'product_cat', $item['product_id'])) {

            $total_meet_amount += ($item["line_total"] * $item["quantity"]);
        }
    }
    return $total_meet_amount;
}

function tx_has_meet_free_shipping() {
    $total_meet_amount = tx_get_total_meet_price();
    $free_shipping_threshold = floatVal(get_field('free_shipping_threshold', 'option'));
    return $total_meet_amount >= $free_shipping_threshold;
}

add_action('wp_ajax_nopriv_set_additional_charge_fee', 'set_additional_charge_fee_call');
add_action('wp_ajax_set_additional_charge_fee', 'set_additional_charge_fee_call');

function set_additional_charge_fee_call() {
    $nonce = sanitize_text_field($_POST['nonce']);
    if (!wp_verify_nonce($nonce, 'set_charge-nonce')) {
        die('Busted!');
    }


    if ($_POST['signature'] === 'Signature Required') {
        WC()->session->set('additional_charge', true);
        echo 'true';
    } else {

        WC()->session->set('additional_charge', false);
        echo 'false';
    }

    wp_die();
}

function xa_fedex_rate_request_set_signature($request, $parcels) {
    if (is_admin()) {
        //[HTTP_REFERER] => https://texasdebrazil.com/wp-admin/post.php?post=276665&action=edit
        $position = strpos($_SERVER['HTTP_REFERER'], '=');
        if ($position !== false) {
            $order_id = substr($_SERVER['HTTP_REFERER'], $position, 0);
            if ($order = wc_get_order($order_id)) {
                if ('Signature Required' == get_post_meta($order_id, 'signature', true)) {
                    foreach ($request["RequestedShipment"]["RequestedPackageLineItems"] as $key => $item) {
                        if (!isset($request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']))//['SpecialServiceTypes']
                            $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested'] = [];
                        $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SpecialServiceTypes'] = [];
                        $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SpecialServiceTypes'][] = 'SIGNATURE_OPTION';
                        $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SignatureOptionDetail'] = [];
                        $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SignatureOptionDetail']['OptionType'] = 'DIRECT';
                    }
                }
            }
        }

        //error_log('xa_fedex_rate_request_set_signature; ' . print_r($request, true));



        return $request;
    } elseif (!empty(WC()->session)) {


        global $woocommerce;


        $charge = WC()->session->get('additional_charge', false);
        if ($charge) {
            foreach ($request["RequestedShipment"]["RequestedPackageLineItems"] as $key => $item) {

                if (!isset($request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']))//['SpecialServiceTypes']
                    $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested'] = [];
                $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SpecialServiceTypes'] = [];
                $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SpecialServiceTypes'][] = 'SIGNATURE_OPTION';
                $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SignatureOptionDetail'] = [];
                $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['SpecialServicesRequested']['SignatureOptionDetail']['OptionType'] = 'DIRECT';
            }
        }
        //if (isset($_COOKIE['signature']))


        foreach ($request["RequestedShipment"]["RequestedPackageLineItems"] as $key => $item) {
            if (isset($request["RequestedShipment"]["RequestedPackageLineItems"][$key]['InsuredValue'])) {
                $request["RequestedShipment"]["RequestedPackageLineItems"][$key]['InsuredValue']['Amount'] = 100;
            }
        }


        $request["RequestedShipment"]['TotalInsuredValue']['Amount'] = 100;
        //error_log('xa_fedex_rate_request_set_signature; ' . print_r($request, true));
    }


    return $request;
}

add_filter('xa_fedex_rate_request', 'xa_fedex_rate_request_set_signature', 11, 2);

function avoid_cache_order_review($data) {
    $address = !empty($_POST['address_2']) ? $_POST['address_2'] : '';
    $address_s = !empty($_POST['s_address_2']) ? $_POST['s_address_2'] : '';
    
    $_POST['address_2'] = $address . rand(0, 9999);
    $_POST['s_address_2'] = $address_s . rand(0, 9999);
}

add_action('woocommerce_checkout_update_order_review', 'avoid_cache_order_review', 1, 10);


add_action('wp', 'tx_reset_sessions');

function tx_reset_sessions() {
    if (!is_ajax() && !is_admin()) {
        WC()->session->set('for_monday', false);
        WC()->session->set('additional_charge', false);
    }
}

/*
 * custom hook
 * D:\xampp\htdocs\texasdebrazil\wp-content\plugins\fedex-woocommerce-shipping\includes\class-wf-fedex-woocommerce-shipping-admin.php - L 1295

 *  */
add_filter('wf_customize_fedex_packages', function($fedex_packages, $package, $order_id) {
    //error_log('wf_customize_fedex_packages params: ' . print_r([$order_id, get_post_meta($order_id, 'signature', true)], true));
    if ('Signature Required' == get_post_meta($order_id, 'signature', true)) {
        foreach ($fedex_packages as &$fedex_package) {
            $fedex_package['signature_option'] = 4;
        }
    }
    //error_log('wf_customize_fedex_packages: ' . print_r($fedex_packages, true));
    return $fedex_packages;
}, 10, 3);

class TxShopCategories {

    public function __construct() {
        add_action('admin_footer', [$this, 'admin_footer']);
        add_filter('xa_fedex_rate_request', [$this, 'xa_fedex_rate_request_set_next_working_day'], 10, 2);

        add_action('wp_ajax_set_meats_merch_shipping', [$this, 'set_meats_merch_shipping']);
        add_action('wp_ajax_set_shipping_holidays', [$this, 'set_shipping_holidays']);
    }

    function set_shipping_holidays() {
        if (!empty($_POST['dates'])) {
            update_option('shipping_holidays', json_encode($_POST['dates']));
        }
        var_dump('d', get_option('shipping_holidays', []));
    }

    function admin_footer() {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                const table = $("#service_options");
                if (table.length) {
                    const get_checkboxes = function (type, code, services_enabled) {
                        let output = '';

                        for (let d = 1; d <= 5; d++) {
                            let enabled = typeof services_enabled[type] != 'undefined' && typeof services_enabled[type][d] != 'undefined' && typeof services_enabled[type][d][code] != 'undefined' && services_enabled[type][d][code] ? 'checked=""' : '';
                            output += `<input style="display:none;" type="checkbox" data-day="${d}" data-service="${code}" ${enabled} data-type="${type}" class="checkBoxMeatMearch day-${d}" size="3" />`
                        }
                        return output;
                    }
                    table.find("table.fedex_services").before(`<div style="margin-bottom:11px;display:flex;align-items:center;gap:7px;"><label>Select shipping day</label>
                    <select id="shipping-day"><option value="1" selected="">Monday</option><option value="2">tursday</option><option value="3">Wednseday</option><option value="4">thursday</option>
                    <option value="5">Friday</option></select></div>`);

                    $('#shipping-day').change(function () {
                        $('.checkBoxMeatMearch').hide();
                        $('.day-' + $(this).val()).show();

                    });
                    const services_enabled = JSON.parse('<?php echo json_encode(get_option('meats_merch_shipping_days', [])); ?>');
                    console.log(services_enabled);
                    table.find("th").eq(3).after(`<th>Meats</th><th>Merch</th>`)

                    table.find('tr').each(function () {
                        let code = $(this).find('td').eq(1).find('strong').text();

                        if (typeof code != 'undefined') {
                            let tr = $(this).find('td').eq(3);
                            let meat_checkboxes = get_checkboxes('meats', code, services_enabled);
                            let merch_checkboxes = get_checkboxes('merch', code, services_enabled);

                            //                            let enabled_meat = typeof services_enabled['meats'][code] != 'undefined' && services_enabled['meats'][code] ? 'checked=""' : '';
                            //                        let enabled_merch = typeof services_enabled['merch'][code] != 'undefined' && services_enabled['merch'][code] ? 'checked=""' : '';


                            //console.log(code, typeof services_enabled['meats'][code], services_enabled[code]);
                            tr.after(`<td>${meat_checkboxes}</td><td>${merch_checkboxes}</td>`);
                        }
                    });

                    $('.checkBoxMeatMearch').click(function () {
                        $.post('<?php echo admin_url('admin-ajax.php'); ?>',
                                {
                                    action: 'set_meats_merch_shipping',
                                    type: $(this).data('type'),
                                    code: $(this).data('service'),
                                    day: $(this).data('day'),
                                    enabled: $(this).is(':checked')
                                }, function (result) {

                        });

                    });
                    $('.day-1').show();
                }
                const working_days = $('#woocommerce_wf_fedex_woocommerce_shipping_fedex_working_days')
                if (working_days.length) {
                    working_days.closest('tr').after(`<tr><th scope="row" class="titledesc">
                                <label for="holidays-datepicker">Shipping holidays <span class="woocommerce-help-tip"></span></label>
                        </th><td class="forminp"><div id="holidays-datepicker" class="fedex_general_tab"></div></td></tr>`);



                    // Maintain array of dates
                    var dates = JSON.parse('<?php echo get_option('shipping_holidays', '[]'); ?>');
                    //var dates = new Array();


                    function addDate(date) {
                        if (jQuery.inArray(date, dates) < 0) {
                            //                            var year = date.getFullYear();
                            //                        
                            //                            var month = padNumber(date.getMonth() + 1);
                            //                            var day = padNumber(date.getDate());
                            //               
                            //                            var dateString = month + "/" + day + "/" + year;
                            dates.push(date);
                            //                            setTimeout(function () {
                            //                                $('.ui-state-active').parent().addClass('ui-state-highlight');
                            //                            }, 100);
                        }
                    }

                    function removeDate(index) {
                        console.log('removeDate');
                        dates.splice(index, 1);
                        //                        setTimeout(function () {
                        //                            $('.ui-state-active').parent().removeClass('ui-state-highlight');
                        //                        }, 100);

                    }

                    // Adds a date if we don't have it yet, else remove it
                    function addOrRemoveDate(date) {
                        var index = jQuery.inArray(date, dates);
                        if (index >= 0)
                            removeDate(index);
                        else
                            addDate(date);
                    }

                    // Takes a 1-digit number and inserts a zero before it
                    function padNumber(number) {
                        var ret = new String(number);
                        if (ret.length == 1)
                            ret = "0" + ret;
                        return ret;
                    }


                    $('#holidays-datepicker').datepicker({
                        dateFormat: "mm/dd/yy",
                        onSelect: function (dateText, inst) {
                            console.log(dateText, inst, this);
                            addOrRemoveDate(dateText);
                            $.post('<?php echo admin_url('admin-ajax.php'); ?>',
                                    {
                                        action: 'set_shipping_holidays',
                                        dates: dates
                                    }, function (result) {

                            });
                        },
                        beforeShowDay: function (date) {
                            console.log(dates, date);
                            //                            var gotDate = $.inArray($.datepicker.formatDate($(this).datepicker('option', 'dateFormat'), date), dates);
                            //                            if (gotDate >= 0) {
                            //                                return [false,"ui-state-highlight", "Event Name"];
                            //                            }
                            //                            return [true, ""];

                            var year = date.getFullYear();
                            // months and days are inserted into the array in the form, e.g "01/01/2009", but here the format is "1/1/2009"
                            var month = padNumber(date.getMonth() + 1);
                            var day = padNumber(date.getDate());
                            // This depends on the datepicker's date format
                            var dateString = month + "/" + day + "/" + year;

                            var gotDate = jQuery.inArray(dateString, dates);
                            console.log(dates);
                            if (gotDate >= 0) {
                                // Enable date so it can be deselected. Set style to be highlighted
                                return [true, "ui-state-highlight"];
                            }
                            // Dates not in the array are left enabled, but with no extra style
                            return [true, ""];
                        }
                    });


                }
            })
        </script>
        <style>
            #holidays-datepicker .ui-state-highlight a{
                background: red;
                color:white;

            }
            #holidays-datepicker .ui-datepicker-inline.ui-datepicker{
                width: 275px;
            }
            #holidays-datepicker table.ui-datepicker-calendar th{
                padding-right: 14px;
            }
        </style>

        <?php
        //meat_ice_packages_select
        //wc-settings
    }

    public function get_next_working_day($shippingDay, $shipTimeStamp) {
        $working_days = tx_get_fedex_settings('fedex_working_days');
        //$shipping_holidays = array_map(function($item){return str_replace('\\', '', $item); }, get_option('shipping_holidays', []));
        $shipping_holidays = json_decode(get_option('shipping_holidays', '[]'), true);

        $skipedDays = 0;

        $day_order = array(
            0 => 'Sun',
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thu',
            5 => 'Fri',
            6 => 'Sat',
        );

        //error_log('$shipping_holidays'.print_r($shipping_holidays,true));


        $date = new DateTime($shipTimeStamp);

        $shippingDayKey = array_search($shippingDay, $day_order);

        for ($i = 0; $i < 800; $i++) {

            $found_index = array_search($day_order[$shippingDayKey], $working_days);
            if (!empty($found_index) || $found_index === 0) {

                $formattedDate = date('m/d/Y', strtotime($shipTimeStamp . ' + ' . $skipedDays . ' days'));
                if (!in_array($formattedDate, $shipping_holidays)) {
                    break;
                }
            }
            $skipedDays++;

            if ($shippingDayKey <= 5)
                $shippingDayKey++;
            else
                $shippingDayKey = 0;
        }

        $date->modify("+ $skipedDays days");

        return $date->format('c');
    }

    function xa_fedex_rate_request_set_next_working_day($request, $parcels) {

        if (empty(WC()->session))
            return $request;

        $timestamp = $request["RequestedShipment"]["ShipTimestamp"];

        //error_log('xa_fedex_rate_request_set_next_working_day 1111' . print_r($timestamp, true));

        //["09\/21\/2022","09\/22\/2022","09\/19\/2022","09\/11\/2022","10\/08\/2022","09\/23\/2022"]
        $date = new DateTime($timestamp);
        $shippingDay = $date->format('D');
        $timestamp = $request["RequestedShipment"]["ShipTimestamp"] = $this->get_next_working_day($shippingDay, $timestamp);

        //'2021-06-17T14:18:50-05:00'
        //$request["RequestedShipment"]["ShipTimestamp"]='2021-07-01T14:00:00-05:00';
        //var_dump($request["RequestedShipment"]["ShipTimestamp"]);
        //$request["RequestedShipment"]["ShipTimestamp"] = date('c', strtotime('next thursday'));
        //$timestamp = date('c', strtotime('-5 hours ' . $request["RequestedShipment"]["ShipTimestamp"]));
        //$timestamp = date('c', strtotime('-0 hours ' . $request["RequestedShipment"]["ShipTimestamp"]));
        //error_log('xa_fedex_rate_request_set_next_working_day' . print_r($timestamp, true));





        return $request;
    }

}

function tx_get_fedex_settings($key = null) {
    $fedex_settings = get_option('woocommerce_' . WF_Fedex_ID . '_settings', array());
    if ($key) {
        return isset($fedex_settings[$key]) ? $fedex_settings[$key] : false;
    }
    return $fedex_settings;
}

new TxShopCategories();


