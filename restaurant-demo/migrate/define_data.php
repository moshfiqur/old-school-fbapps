<?php

include_once '../demo_libs/config.php'; // PASSWD, etc.
include_once '../demo_libs/mysql_data.php'; // Relational data
include_once '../demo_libs/display.php';
include_once '../demo_libs/profile.php';
include_once '../demo_libs/facebook-platform/client/facebook.php';

// Demo: Should only be the admin running this script.  Do add
// appropriate accessors, or put in an appropriate directory.

$facebook = new Facebook($facebook_config['api_key'], $facebook_config['secret']
);

$facebook->require_frame();
$user = $facebook->require_login();

// if you've mistakenly created data objects, use this function to destroy first.
destroy_data();

define_objects();
define_associations();

print '<fb:success message="FINISHED defining your fb data objects and assocations." />';

function define_associations()
{
  global $facebook;

  $obj1 = array('alias' => 'user');

  $obj2 = array('alias' => 'restaurant',
      'object_type' => 'restaurant_info');

  $result = $facebook->api_client->data_defineAssociation('has_reviewed_restaurant', 3, $obj1, $obj2, 'reviewed_by_user');

  $obj1 = array('alias' => 'zip');

  $obj2 = array('alias' => 'restaurant',
      'object_type' => 'restaurant_info');

  $result = $facebook->api_client->data_defineAssociation('zip_has_restaurant', 1, $obj1, $obj2);

}

function define_objects()
{
  global $facebook;
  // Create object type: restaurant_info
  $facebook->api_client->data_createObjectType('restaurant_info');

  // Create properties for restaurant

  $facebook->api_client->data_defineObjectProperty('restaurant_info', 'restaurant', 1);

  $facebook->api_client->data_defineObjectProperty('restaurant_info', 'name', 2);

  $facebook->api_client->data_defineObjectProperty('restaurant_info', 'pic', 3);
}

function destroy_data()
{
  global $facebook;
   $facebook->api_client->data_dropObjectType('restaurant_info');
   $facebook->api_client->data_undefineAssociation('has_reviewed_restaurant');
   $facebook->api_client->data_undefineAssociation('reviewed_by_user');
   $facebook->api_client->data_undefineAssociation('zip_has_restaurant');
}
?>


