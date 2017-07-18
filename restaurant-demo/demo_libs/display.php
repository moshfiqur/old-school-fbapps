<?php


function start_page()
{
  print '<div style="padding: 0px 20px 20px">';
}

function close_page()
{
  print '</div>';
}

function pic($url, $size)
{
  if (!preg_match('/^(.*)[a-z]([0-9_]+.jpg)$/', $url, $parts))
    return 'error';
  return $parts[1] . $size . $parts[2];
}

function print_restaurant($r)
{
  global $APP_ROOT_URL;
  print '<div style="width: 200px; float: left; height: 140px">';
  print '<a href="'.$APP_ROOT_URL.'/index.php?action=view&restaurant='.$r['restaurant'].'"><img src="'.pic($r['pic'], 's').'" border=0></a>';
  print '<h4 style="padding-top: 3px"><a href="'.$APP_ROOT_URL.'/index.php?action=view&restaurant='.$r['restaurant'].'">';
  print $r['name'].'</a></h4>';

  print '</div>';
}

function print_ajax_rater($page, $user, $restaurant_id, $current_rating)
{
  print '<form id="foo"><div id="vote"> <h3>Add a Rating:</h3><br/>
  <a href="#" clickrewriteid="vote" clickrewriteform="foo" clickrewriteurl="'.$page.'?user='.$user.'&restaurant_id='.$restaurant_id.'&rating=1"> Poor</a><br/>
  <a href="#" clickrewriteid="vote" clickrewriteform="foo" clickrewriteurl="'.$page.'?user='.$user.'&restaurant_id='.$restaurant_id.'&rating=2"> Fair</a><br/>
  <a href="#" clickrewriteid="vote" clickrewriteform="foo" clickrewriteurl="'.$page.'?user='.$user.'&restaurant_id='.$restaurant_id.'&rating=3"> Good</a><br/>
  <a href="#" clickrewriteid="vote" clickrewriteform="foo" clickrewriteurl="'.$page.'?user='.$user.'&restaurant_id='.$restaurant_id.'&rating=4"> Quite Good</a><br/>
  <a href="#" clickrewriteid="vote" clickrewriteform="foo" clickrewriteurl="'.$page.'?user='.$user.'&restaurant_id='.$restaurant_id.'&rating=5"> Awesometown</a><br/>';



  if ($current_rating !== 0)
  {
    print '<br/>';
    print'<a href="#" clickrewriteid="vote" clickrewriteform="foo" clickrewriteurl="'.$page.'?user='.$user.'&restaurant_id='.$restaurant_id.'&rating=0"> REMOVE MY RATING</a><br/>';
  }

  print '</div>
  </form>';

}

function print_nonajax_rater($user, $restaurant_id, $current_rating)
{
  global $APP_ROOT_URL;
  print '<h3>Add a rating:</h3><br/>';
  print '<a href="'.$APP_ROOT_URL.'/index.php?action=rate&restaurant='.$restaurant_id.'&rating=1"> Poor</a><br/>';
  print '<a href="'.$APP_ROOT_URL.'/index.php?action=rate&restaurant='.$restaurant_id.'&rating=2"> Fair</a><br/>';
  print '<a href="'.$APP_ROOT_URL.'/index.php?action=rate&restaurant='.$restaurant_id.'&rating=3"> Good</a><br/>';
  print '<a href="'.$APP_ROOT_URL.'/index.php?action=rate&restaurant='.$restaurant_id.'&rating=4"> Quite Good</a><br/>';
  print '<a href="'.$APP_ROOT_URL.'/index.php?action=rate&restaurant='.$restaurant_id.'&rating=5"> Awesometown</a><br/>';
  if ($current_rating !== 0)
  {
    print '<br/>';
    print '<a href="'.$APP_ROOT_URL.'/index.php?action=rate&restaurant='.$restaurant_id.'&rating=0"> REMOVE MY RATING</a><br/>';
  }

}

?>

