<?php

function fb_data_get_all_restaurants_data()
{
  global $facebook, $DEFAULT_ZIP;
  if (!$result = $facebook->api_client->data_getAssociatedObjects('zip_has_restaurant', $DEFAULT_ZIP, true))
  {
    $result = array();
  }

  $all_restaurants = array();
  $all_rest_data = array();
  foreach ($result as $id_arr)
  {
    $all_restaurants[] = $id_arr['id2'];
  }
  if ($all_restaurants)
  {
    $result = $facebook->api_client->data_getObjects($all_restaurants);
    foreach ($result as $rest_data)
    {
      $assoc_id = $rest_data[1];
      $orig_id = $rest_data[2];
      $name = $rest_data[3];
      $pic = $rest_data[4];
      $all_rest_data[$assoc_id] = array (
          'restaurant' => $assoc_id,
          'id' => $assoc_id,
          'orig_id' => $orig_id,
          'name' => $name,
          'pic' => $pic);
    }
  }
  return $all_rest_data;
}

function fb_data_restaurant_get_users($restaurant)
{
  global $facebook;
  $result = $facebook->api_client->data_getAssociatedObjects('reviewed_by_user', $restaurant, true);
  $user_ids = array();
  foreach ($result as $data)
  {
    $user_ids[] = $data['id2'];
  }
  return $user_ids;
}

function fb_data_user_get_restaurants($user)
{
  global $facebook;
  $result = $facebook->api_client->data_getAssociatedObjects('has_reviewed_restaurant', $user, true);
  $rest_assoc_ids = array();
  foreach ($result as $data)
  {
    $rest_assoc_ids[] = $data['id2'];
  }
  return $rest_assoc_ids;
}

function fb_data_user_rate_restaurant($user, $restaurant, $rating)
{
  global $facebook;
  $facebook->api_client->data_removeAssociation('reviewed_by_user', $restaurant, $user);
  return $facebook->api_client->data_setAssociation('reviewed_by_user', $restaurant, $user, $rating);
}

function fb_data_user_remove_restaurant($user, $restaurant)
{
  global $facebook;
  $facebook->api_client->data_removeAssociation('reviewed_by_user', $restaurant, $user);
}

function fb_data_user_get_restaurant_rating($user, $restaurant)
{
  global $facebook;
  if ($result = $facebook->api_client->data_getAssociations($restaurant, $user, $no_data = 0))
  {
    return $result[0]['data'];
  }
  return 0;

}

function fb_data_get_restaurants_from_friends($friends_array)
{
  global $facebook, $user;

  $counts = array();
  $result = $facebook->api_client->fql_query('SELECT restaurant FROM app.has_reviewed_restaurant WHERE user IN (SELECT uid2 FROM friend WHERE uid1='.$user.')');

  foreach ($result as $result_arr)
  {
    $rest_id = $result_arr['restaurant'];
    $counts[$rest_id]++;
  }
  arsort($counts);
  return array_slice($counts, 0, 10, 1);
}


?>
