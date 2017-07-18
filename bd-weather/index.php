<?php

	require_once("appinclude.php");
	require_once("connection.php");	

?>

<?php
	######################################################################################################################################################
	## GENERATE ALL DATA
	######################################################################################################################################################
	
	// create a new cURL resource
	$ch = curl_init();
	
	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_URL, "http://xml.weather.yahoo.com/forecastrss?p=BGXX0014&u=c");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	// grab URL and pass it to the browser
	$simple = curl_exec($ch);
	
	// close cURL resource, and free up system resources
	curl_close($ch);

	//$simple = "<para><note>simple note</note></para>";
	$p = xml_parser_create();
	xml_parse_into_struct($p, $simple, $vals, $index);
	xml_parser_free($p);
	
	$title = $vals[2]['value'];
	$link = $vals[4]['value'];
	$detailed_link = $link . "#text";
	$last_updated = $vals[10]['value'];
	$city = $vals[14]['attributes']['CITY'];
	$country = $vals[14]['attributes']['COUNTRY'];
	$wind_chill = $vals[18]['attributes']['CHILL'];
	$wind_dir = $vals[18]['attributes']['DIRECTION'];
	$wind_speed = $vals[18]['attributes']['SPEED'];
	$humidity = $vals[20]['attributes']['HUMIDITY'];
	$visibility = $vals[20]['attributes']['VISIBILITY'];
	$sunrise = $vals[22]['attributes']['SUNRISE'];
	$sunset = $vals[22]['attributes']['SUNSET'];
	$latitude = $vals[40]['value'];
	$longitude = $vals[42]['value'];
	$condition_text = $vals[48]['attributes']['TEXT'];
	$condition_code = $vals[48]['attributes']['CODE'];
	$condition_temp = $vals[48]['attributes']['TEMP'];
	$condition_high = $vals[52]['attributes']['HIGH'];
	$condition_low = $vals[52]['attributes']['LOW'];
	// generate the image for current weather status
	$time = date("G", time());
	if($time > 6 && $time < 18)
	{
		$flag = "d";
	}
	else
	{
		$flag = "n";
	}
	$condition_img = "http://l.yimg.com/us.yimg.com/i/us/nws/weather/gr/" . $condition_code . $flag . ".png";
	
	$forecast_day = $vals[54]['attributes']['DAY'];
	$forecast_date = $vals[54]['attributes']['DATE'];
	$forecast_low = $vals[54]['attributes']['LOW'];
	$forecast_high = $vals[54]['attributes']['HIGH'];
	$forecast_text = $vals[54]['attributes']['TEXT'];
	$forecast_code = $vals[54]['attributes']['CODE'];
	// generate the image for current weather status
	$forecast_img = "http://l.yimg.com/us.yimg.com/i/us/we/52/" . $forecast_code . ".gif";
	
?>

<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
	$profile = '<table width="550" border="0" cellspacing="0" cellpadding="3" style="background-color:#A6AEBB; border: 5px solid #CCCCCC;">
				  <tr>
					<td colspan="2" style="font-size:14px; font-weight:bold;">' . $title . '</td>
				  </tr>
				  <tr>
					<td colspan="2" style="border-bottom:1px solid #989FAC;">' . $last_updated . '</td>
				  </tr>
				  <tr>
					<td width="200" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="3">
						  <tr>
							<td>Humidity</td>
							<td>: ' . $humidity . '%</td>
						  </tr>
						  <tr>
							<td>Visibility</td>
							<td>: ' . $visibility . ' km </td>
						  </tr>
						  <tr>
							<td>Dewpoint </td>
							<td>: ' . $wind_chill . '&deg;C</td>
						  </tr>
						  <tr>
							<td>Wind</td>
							<td>: ' . $wind_dir . '&deg; at ' . $wind_speed . ' kph</td>
						  </tr>
						  <tr>
							<td>Sunrise</td>
							<td>: ' . $sunrise . '</td>
						  </tr>
						  <tr>
							<td>Sunset</td>
							<td>: ' . $sunset . '</td>
						  </tr>
						</table>
					</td>
					<td width="300" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="3" style="background-image:url(' . $condition_img . '); height:180px; background-repeat:no-repeat;">
						  <tr>
							<td colspan="2">&nbsp;</td>
						  </tr>
						  <tr>
							<td colspan="2">&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td align="right" style="font-size:24px; font-weight:bold;">' . $condition_text . ', ' . $condition_temp . '&deg;C</td>
						  </tr>
						  <tr>
							<td align="right" valign="top" colspan="2">High: ' . $condition_high . '&deg;C ' . 'Low: ' . $condition_low . '&deg;C </td>
						  </tr>
						</table>
					</td>
				  </tr>
				</table>
				<br/>
				<table width="550" border="0" cellspacing="0" cellpadding="3" style="background-color:#A6AEBB; border: 5px solid #CCCCCC;">
				  <tr>
					<td colspan="2" style="font-size:14px; font-weight:bold;">Tomorrow&quot;s Forecast </td>
				  </tr>
				  <tr>
					<td colspan="2" style="border-bottom:1px solid #989FAC;">' . $forecast_day . ', ' . $forecast_date . '</td>
				  </tr>
				  <tr>
					<td width="60"><img src="' . $forecast_img . '" /></td>
					<td width="490"><span style="font-size:18px; font-weight:bold;">' . $forecast_text . '</span><br />High: ' . $forecast_high . '&deg;C Low: ' . $forecast_low . '&deg;C </td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td align="right"><a href="http://weather.yahoo.com" target="_blank"><img src="http://us.i1.yimg.com/us.yimg.com/i/us/nt/ma/ma_nws-we_1.gif" border="0" /></a></td>
				  </tr>
				  <tr>
					<td colspan="2" align="right">For detailed weather forecast click <a href="' . $detailed_link . '" target="_blank">here</a></td>
				  </tr>
				</table>';
	
	$facebook->api_client->profile_setFBML($profile, $user);
		
	include("header.php");
	
	echo $profile;
	
	echo "<br/>";
	echo "<br/>";
	
	include("footer.php");
		
?>