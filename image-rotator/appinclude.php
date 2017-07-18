<?php

	require_once 'facebook.php';
	
	$appapikey = 'APP_API_KEY';
	$appsecret = 'APP_SECRET';
	$facebook = new Facebook($appapikey, $appsecret);
	$user = $facebook->require_login();
	
	//[todo: change the following url to your callback url]
	$callbackurl = 'http://september-rain.info/fb/apps/image-rotator/';
	
	//catch the exception that gets thrown if the cookie has an invalid session_key in it
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