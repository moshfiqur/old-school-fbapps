<?php

	require_once 'facebook.php';
	
	$appapikey = 'APP_API_KEY';
	$appsecret = 'APP_SECRET';
	
	$facebook = new Facebook($appapikey, $appsecret);
	$user = $facebook->require_login();
	
	$appcallbackurl = 'http://september-rain.info/fb/apps/bd-weather/';
	$applink = "http://apps.facebook.com/bd-weather/";
	
	try {
	  if (!$facebook->api_client->users_isAppAdded()) {
		$facebook->redirect($facebook->get_add_url());
	  }
	} catch (Exception $ex) {
	  //this will clear cookies for your application and redirect them to a login prompt
	  $facebook->set_user(null, null);
	  $facebook->redirect($appcallbackurl);
	}
		
?>