<?php
$user_ip = $_SERVER['REMOTE_ADDR'];

//unset($_COOKIE[$user_ip . '_latlong_']);

if ($user_ip != '127.0.0.1') {

    error_log__('$_COOKIE ' . $user_ip . print_r($_COOKIE, true));

    $ip_key = str_replace('.', '_', $user_ip).'lat_long';

    if (isset($_COOKIE[$ip_key])) {
        $latlong = json_decode(str_replace('\\', '', $_COOKIE[$ip_key]), true);
        
        error_log__('$latlong ' . print_r([$ip_key,$_COOKIE[$ip_key],$latlong], true));

        if (isset($latlong['user_lat']) && isset($latlong['user_long'])) {
            $user_lat = $latlong['user_lat'];
            $user_long = $latlong['user_long'];
            error_log__('ipapi**************FROM COOCKIE ' . $user_long);
        } else {
            $user_lat = 34.1745558430435;
            $user_long = -99.76303032576004;
            error_log__('ipapi**************FROM COOCKIE ERROR ' . $user_long);
        }
    } else {
        //$latlong = file_get_contents("https://ipapi.co/$user_ip/latlong/");
        $latlong=false;

        if (isset($_GET['ipapi'])) {
            error_log__('ipapilatlong**************');
            error_log__(print_r([$latlong, $city], true));
            exit;
        }

        if ($latlong) {
            $location_array = explode(',', $latlong);
            $user_lat = $location_array[0];
            $user_long = $location_array[1];
        } else {
            $user_lat = 34.1745558430435;
            $user_long = -99.76303032576004;
        }

        $value = json_encode(['user_lat' => $user_lat, 'user_long' => $user_long]);
        $cookie = 'no';//setcookie($ip_key, $value, time() + (60 * 60 * 24 * 15));
        error_log__('ipapilatlong**************FROM IP ' . print_r([$value, $cookie], true));
        error_log__('$_COOKIE222 ' . $user_ip . print_r($_COOKIE, true));
    }
}

function error_log__($value) {
    return;
    if ($_SERVER['REMOTE_ADDR'] == '77.228.116.64') {
        error_log($value);
    }
}
?>
<input type="hidden" name="currlatlong" value="<?php echo $user_lat . ',' . $user_long; ?>">