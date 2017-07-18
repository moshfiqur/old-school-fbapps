<?php

function mysql_get_all_restaurants_data()
{
  $q = query(sprintf('SELECT restaurant, name, pic FROM restaurant WHERE 1'));
  $results = array();
  while($row = mysql_fetch_assoc($q))
  {
    $row['name'] = stripslashes($row['name']);
    $row['id'] = $row['restaurant'];
    $results[$row['restaurant']] = $row;
  }
  return $results;
}

function mysql_restaurant_get_users($restaurant)
{
  $q = query(sprintf('SELECT user FROM restaurant_user WHERE restaurant = %d ORDER BY time DESC LIMIT 100', $restaurant));

  $ret = array();
  while(list($id) = mysql_fetch_array($q))
    $ret[$id] = $id;

  return $ret;
}

function mysql_user_get_restaurants($user)
{
  $q = query(sprintf('SELECT restaurant FROM restaurant_user WHERE user = %d ORDER BY time DESC', $user));

  $ret = array();

  while(list($id) = mysql_fetch_array($q))
    $ret[$id] = $id;

  return $ret;
}

function mysql_user_rate_restaurant($user, $restaurant, $rating)
{
  return query(sprintf('REPLACE INTO restaurant_user (user, restaurant, review_score) VALUES (%d, %d, %d)', $user, $restaurant, $rating));
}

function mysql_user_remove_restaurant($user, $restaurant)
{
  return query(sprintf('DELETE FROM restaurant_user WHERE restaurant = %d AND user = %d', $restaurant, $user));
}

function mysql_user_get_restaurant_rating($user, $restaurant)
{
  $q = query(sprintf('SELECT review_score from restaurant_user WHERE user = %d AND restaurant = %d', $user, $restaurant));
  if ($row = mysql_fetch_assoc($q)) {
    return $row['review_score'];
  } else {
    return 0;
  }
}

function mysql_get_restaurants_from_friends($friends_array)
{
  $sql_list = '(' . implode(',', $friends_array) . ')';
  $q = query(sprintf('SELECT restaurant, count(user) as count FROM restaurant_user WHERE user IN '.$sql_list . ' GROUP BY restaurant ORDER BY count DESC LIMIT 10'));
  $rests = array();
  while ($row = mysql_fetch_assoc($q))
  {
    $rests[$row['restaurant']] = $row['count'];
  }
  return $rests;
}

function query($sql)
{
    global $conn;
    return mysql_query($sql, $conn);
}

?>
