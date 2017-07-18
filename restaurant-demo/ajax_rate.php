<?php

include_once 'demo_libs/config.php';
include_once 'demo_libs/data_wrapper.php';
include_once 'demo_libs/facebook-platform/client/facebook.php';

$facebook = new Facebook($facebook_config['api_key'], $facebook_config['secret']);

$user = $facebook->require_login();

$restaurant_id = $_REQUEST['restaurant_id'];
$rating = (int) $_REQUEST['rating'];


if ($rating >= 1 && $rating <= 5)
{
  user_rate_restaurant($user, $restaurant_id, $rating);
  print 'New rating : <br/>';
  print '<img src="'.$CODE_ROOT_URL.'/images/'.$rating.'.gif>';
} else {
  user_remove_restaurant($user, $restaurant_id);
  print 'Restaurant rating removed.';
}
?>

