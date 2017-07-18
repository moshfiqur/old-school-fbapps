<?php
include_once '../demo_libs/config.php'; // PASSWD, etc.
include_once '../demo_libs/mysql_data.php'; // Relational data
include_once '../demo_libs/fb_datastore_data.php'; // FB Data store data
include_once '../demo_libs/facebook-platform/client/facebook.php';

$facebook = new Facebook($facebook_config['api_key'], $facebook_config['secret']);

// Demo: Should only be the admin running this script.  Do add
// appropriate accessors, or put in an appropriate directory.
$facebook->require_frame();
$user = $facebook->require_login();

migrate_data();
print '<fb:success message="Migration done" />';

function mysql_get_all_restaurants()
{
  $q = query(sprintf('SELECT * FROM restaurant WHERE 1'));
  $results = array();
  while ($row = mysql_fetch_assoc($q))
  {
    $results[$row['restaurant']] = $row;
  }
  return $results;
}

function mysql_get_all_user_data()
{
  $q = query(sprintf('SELECT * FROM restaurant_user WHERE 1'));
  $results = array();
  while($row = mysql_fetch_assoc($q))
  {
    $results[] = $row;
  }
  return $results;
}


function migrate_data()
{
  $user_data = mysql_get_all_user_data();
  $restaurant_infos = mysql_get_all_restaurants();
  $old_to_new_map = fb_data_create_new_restaurants($restaurant_infos);
  foreach ($user_data as $data)
  {
    $old_id = $data['restaurant'];
    $new_id = $old_to_new_map[$old_id];

    fb_data_user_rate_restaurant($data['user'], $new_id, $data['review_score']);
    error_log("MIGRATE: ADDING ASSOC between old rest: $old_id, new: $new_id, user: {$data['user']}, rating = {$data['review_score']}");
  }
  error_log("MIGRATE: DONE");
}


function fb_data_add_new_restaurant($name, $pic)
{
  global $facebook, $DEFAULT_ZIP;
  $properties = array ('name' => $name, 'pic' => $pic);
  $new_id = $facebook->api_client->data_createObject('restaurant_info', $properties);
  if ($new_id)
  {
    $facebook->api_client->data_setAssociation('zip_has_restaurant', $DEFAULT_ZIP, $ne
w_id);
  }
  error_log("MIGRATE: Adding rest: $new_id");
  return $new_id;

}

function  fb_data_create_new_restaurants($restaurant_infos)
{
  error_log("MIGRATE: creating new rests.");
  $old_to_new_map = array();
  foreach ($restaurant_infos as $old_id => $restaurant_info)
  {
    $return_id = fb_data_add_new_restaurant($restaurant_info['name'], $restaurant_info['pic']);
    error_log("MIGRATE: old restaurant: $old_id, new restaurant: $return_id");
    $old_to_new_map[$old_id] = $return_id;
  }
  return $old_to_new_map;
}
?>
