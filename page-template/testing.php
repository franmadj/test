<?php 
/*
Template Name:Testing
*/

?>
<h1>Testing</h1>
<?php
global $wpdb;
$result = $wpdb->get_row("SELECT *  FROM ".$wpdb->prefix."cronjob WHERE  order_id=120", ARRAY_A);
if($result):
    $bonuscard = unserialize($result['bonus_cards']);
    $cardcount10 = $bonuscard['bonus_10'];
    $cardcount25 = $bonuscard['bonus_25'];
else:
    $order_id = 71690;
    $cardcount10 = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."bonuscard where order_id = $order_id AND amount = 10" );
    $cardcount25 = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."bonuscard where order_id = $order_id AND amount = 25" );
    echo "<p>User count is 10  { $cardcount10}</p>";
    echo "<p>User count is 10  { $cardcount25}</p>";
endif;




?>
