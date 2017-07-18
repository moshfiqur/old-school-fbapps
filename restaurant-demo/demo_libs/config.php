<?php

// Demo: Change these to 1 to juice your application with some example
// extended functionality.
$USE_DATA_API = 0;
$USE_JS = 0;
$USE_AJAX = 0;

$APP_ROOT_URL = 'http://apps.facebook.com/restaurant-demo';
$CODE_ROOT_URL = 'http://september-rain.info/fb/apps/restaurant-demo';

$facebook_config['api_key'] = '8959273a2d09fb17077a5e8321d3db56';
$facebook_config['secret'] = '84a36a6911ff51e9ace9b8e7e52f1956';
$facebook_config['debug'] = 0;

// Demo: Exercise for the reader: Try adding more zip codes 
// through associations!
$DEFAULT_ZIP = 94301;

$conn = mysql_connect('localhost', 'septembe_user', 'user8DB');
mysql_select_db('septembe_facebookapp', $conn);


?>
