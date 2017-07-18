<?php

function republish_user_profile($user)
{
  global $restaurant_data, $facebook, $APP_ROOT_URL;

  $markup = 'Reviewed Restaurants <p/>';
  $count=0;

  $all_user_restaurants = user_get_restaurants($user);
  foreach ($all_user_restaurants as $id) {
    $r = $restaurant_data[$id];

    $url = $APP_ROOT_URL . '/index.php?action=view&restaurant='.$id;
    $markup .= '<b><a href="'.$url.'">'.$r['name'].'</a></b><br/>';
    $count += 1;
    if ($count >= 8)
      break;
  }
  
  $facebook->api_client->profile_setFBML($markup, $user);
  return $markup;
}

?>

