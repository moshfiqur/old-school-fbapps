<?php

// Demo: Reviewed Restaurants - using old and new features of FB platform.

include_once 'demo_libs/config.php';
include_once 'demo_libs/data_wrapper.php';

include_once 'demo_libs/js_typeahead.php';
include_once 'demo_libs/display.php';
include_once 'demo_libs/profile.php';
include_once 'demo_libs/facebook-platform/client/facebook.php';

$facebook = new Facebook($facebook_config['api_key'], $facebook_config['secret']);

$facebook->require_frame();
$user = $facebook->require_login();

$restaurant_data = get_all_restaurants_data();

$my_restaurants = user_get_restaurants($user);

$action = $_REQUEST['action'];

if ($action == 'rate') {

  $id = (int)$_REQUEST['restaurant'];
  $rating = (int)$_REQUEST['rating'];

  $facebook->require_install();

  if (isset($_REQUEST['confirm'])) {

    if ($rating === 0) {
      user_remove_restaurant($user, $id);
    } else {
      user_rate_restaurant($user, $id, $rating);
      republish_user_profile($user);
    }


    if ($rating > 0) {
      $restaurant_url = $APP_ROOT_URL . '/index.php?action=view&restaurant=' . $id;
      $restaurant_link = '<a href="'.$restaurant_url.'">' . $restaurant_data[$id]['name'] . '</a>';
      $facebook->api_client->feed_publishStoryToUser('You have rated a restaurant',
        'Enjoy your next meal at ' . $restaurant_link . '.  Bon appetit!');

      // Demo: If you want to publish to this user's friends, 
      // use something like this.
      //$facebook->api_client->feed_publishActionOfUser('<fb:userlink uid="'
      //. $user.'" shownetwork="false"/> added a restaurant.', 'Check it out');
    }

    $facebook->redirect('?');
    exit;
  }

  if (!isset($restaurant_data[$id])) {
    print 'invalid restaurant id';
    exit;
  }

  $r = $restaurant_data[$id];

  print '<fb:header>Restaurants</fb:header>';
  start_page();

  $verb = 'Rate';
  $prep = '';
  if ($rating === 0) {
    $verb = 'Remove';
    $prep = 'from your list';
  }

  print '<h2>'.$verb.' '.$r['name'].'</h2>';

  print '<p>Are you sure you want to '.strtolower($verb).' this restaurant '.$prep.'?</p>';

  print '<form method="post" action="index.php">';
  print '<input type="hidden" name="restaurant" value="'.$r['id'].'">';
  print '<input type="hidden" name="confirm" value="1">';
  print '<input type="hidden" name="rating" value="'.$rating.'">';
  print '<input type="submit" value="'.$verb.'">';
  print '</form>';

  close_page();
}
else if ($action == 'view') {
  $id = (int)$_REQUEST['restaurant'];

  $r = $restaurant_data[$id];

  print '<fb:header><a href="'.$APP_ROOT_URL.'/">Restaurants</a>: '.$r['name'].'</fb:header>';

  start_page();

  print '<img src="'.pic($r['pic'], 'n').'">';

  $users = restaurant_get_users($id);

  $facebook->api_client->users_getInfo($users, 'name');


  if ($users) {

    print '<h3>Who has rated this place?</h3>';
    print '<table><tr>';
    $count = 0;
    foreach ($users as $reviewer) {
      // xxx center the picture
      print '<td valign="bottom"><fb:profile-pic style="padding: 4px" uid="'.$reviewer.'"/><br><fb:userlink shownetwork=0 uid="'.$reviewer.'" />';
      print ' (<a href="'. $APP_ROOT_URL . '/index.php?action=user&target='.$reviewer.'">restaurants</a>)';
      print '</td>';

      $count++;
      if ($count % 6 == 0)
        print '</tr><tr>';
    }
    print '</tr></table>';
  }

  if ($rating = user_get_restaurant_rating($user, $id))
  {
    print "<br/><h3> Current restaurant rating is: $rating</h3><hr/>";
  }

  // Demo: Toggle here to see adding Mock AJAX.
  if ($USE_AJAX) {
    print_ajax_rater($CODE_ROOT_URL . '/ajax_rate.php', $user, $id, $rating);
  } else {
    print_nonajax_rater($user, $id, $rating);
  }
  print '<br/><a href="'.$APP_ROOT_URL.'/index.php">Go home.</a>';
  close_page();

}
else if ($action == 'user') {

  $target = (int)$_GET['target'];

  $restaurants = user_get_restaurants($target);

  print '<fb:header>';

  print '<fb:name possessive=1 capitalize=1 uid="'.$target.'" /> Restaurants ('.count($restaurants).')</fb:header>';

  start_page();

  foreach ($restaurants as $id) {
    print_restaurant($restaurant_data[$id]);
  }

  close_page();
}
else {

  print '<fb:dashboard>';
  print '</fb:dashboard>';

  start_page();

  print '<h2 style="padding-bottom: 5px">My Restaurants</h2>';
  if ($my_restaurants) {
    print '<ul style="list-style: none; margin: 0px; padding: 0">';
    foreach ($my_restaurants as $id) {
      $some = 1;
      $r = $restaurant_data[$id];

      print '<li style="padding: 2px 0px"><a href="'.$APP_ROOT_URL.'/index.php?action=view&restaurant='.$id.'">'.$r['name'] . '</a></li>';
    }
    print '</ul>';
  }
  else {
    print 'none yet.<br/>';
  }
  print '<br/>';
  print '<br/>';
  print '<h2 style="padding-bottom: 5px">My Friends\' Top Restaurants</h2>';

  $friends = $facebook->api_client->friends_get($user);
  $friend_restaurants = get_restaurants_from_friends($friends);
  print '<ul style="list-style: none; margin: 0; padding: 0">';

  foreach ($friend_restaurants as $id => $count)
  {
    $stored_data = $restaurant_data[$id];
    $name = $stored_data['name'];
    print '<li style="padding: 2px 0px"><a href="'.$APP_ROOT_URL.'/index.php?action=view&restaurant='.$id.'">'.$name . '</a> ('. $count . ')</li>';
  }
  print '</ul>';
  print '<br/>';
  print '<br/>';
  print '<h2 style="padding-bottom: 5px">All Restaurants</h2>';

  // Demo: Toggle here to see adding FBJS.
  if ($USE_JS) {
    print "<br/>Find a particular restaurant:<br/>";
    print_restaurant_typeahead($restaurant_data);
    print "<br/>";
  }

  shuffle($restaurant_data);

  foreach ($restaurant_data as $r)
    print_restaurant($r);

  close_page();
}

?>
