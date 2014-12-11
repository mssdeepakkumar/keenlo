<?php

include_once 'wp-config.php';
global $wpdb;
//echo "<pre>";
	  $cat = $_POST['prdct'];
	  $loc = $_POST['loc'];
	  $act = $_POST['act'];
	  $day = $_POST['day'];
echo "?cat=".$cat."&loc=".$loc."&act=".$act."&day=d".$day;
	
?>
