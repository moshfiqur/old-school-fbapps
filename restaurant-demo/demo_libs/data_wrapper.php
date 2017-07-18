<?php

include_once 'mysql_data.php';
include_once 'fb_datastore_data.php';

if ($USE_DATA_API)
{
  function get_all_restaurants_data()
    { return fb_data_get_all_restaurants_data(); }
  function restaurant_get_users($restaurant)
    { return fb_data_restaurant_get_users($restaurant); }
  function user_get_restaurants($user)
    { return fb_data_user_get_restaurants($user); }
  function get_restaurants_from_friends($friends_array)
    { return fb_data_get_restaurants_from_friends($friends_array); }
  function user_rate_restaurant($user, $restaurant, $rating)
    { return fb_data_user_rate_restaurant($user, $restaurant, $rating); }
  function user_remove_restaurant($user, $restaurant)
    { return fb_data_user_remove_restaurant($user, $restaurant); }
  function user_get_restaurant_rating($user, $restaurant)
    { return fb_data_user_get_restaurant_rating($user, $restaurant); }
} else {
  function get_all_restaurants_data()
    { return mysql_get_all_restaurants_data(); }
  function restaurant_get_users($restaurant)
    { return mysql_restaurant_get_users($restaurant); }
  function user_get_restaurants($user)
    { return mysql_user_get_restaurants($user); }
  function get_restaurants_from_friends($friends_array)
    { return mysql_get_restaurants_from_friends($friends_array); }
  function user_rate_restaurant($user, $restaurant, $rating)
    { return mysql_user_rate_restaurant($user, $restaurant, $rating); }
  function user_remove_restaurant($user, $restaurant)
    { return mysql_user_remove_restaurant($user, $restaurant); }
  function user_get_restaurant_rating($user, $restaurant)
    { return mysql_user_get_restaurant_rating($user, $restaurant); }
}

?>

