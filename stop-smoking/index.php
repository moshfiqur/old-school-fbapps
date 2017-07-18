<?php

	require_once("appinclude.php");
	require_once("connection.php");	

?>

<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
	$markup = '';
	
	$sql = "SELECT t1.image_name FROM fb_ss_image_pool as t1, fb_ss_user as t2 WHERE t2.uid = '$user' and t2.profile = t1.image_id";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)){
		$row = mysql_fetch_array($result);
		$profile = $row['image_name'];
	}else{
		$profile = "canvas-1.jpg";
	}
	
	$sql = "SELECT t1.image_name FROM fb_ss_image_pool as t1, fb_ss_user as t2 WHERE t2.uid = '$user' and t2.canvas = t1.image_id";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)){
		$row = mysql_fetch_array($result);
		$canvas = $row['image_name'];
	}else{
		$canvas = "canvas-1.jpg";
	}
	
	$profile = "<table width='370' border='0' cellspacing='0' cellpadding='0' style='border:3px solid #E90512;' >
					<tr>
						<td>
							<a href='" . $applink . "' >
								<img src='".$appcallbackurl."images/profile/$profile' width='370' border='0' >
							</a>
						</td>
					</tr>
				</table>";
	
	$facebook->api_client->profile_setFBML($profile, $user);
		
	include("header.php");
	
	echo "<table width='600' border='0' cellspacing='0' cellpadding='3' style='border:5px solid #E90512;' align='center'>
			  <tr>
				<td style='color:#333333; font-weight:bold; font-size:14px;'>Today's Quote</td>
			  </tr>
			  <tr>
				<td style='font-size:24px; font-weight:bold; color:#E90512; padding:10px;'>If you can't stop smoking, cancer will!</td>
			  </tr>
		   </table>";
	
	echo "<br/>";
	echo "<br/>";
	
	echo "<table width='600' border='0' cellspacing='0' cellpadding='0' style='border:5px solid #E90512;' align='center'>
			  <tr>
				<td><img src='" . $appcallbackurl . "images/canvas/$canvas' width='600' border='0' /></td>
			  </tr>
		   </table>";
	
	echo "<br/>";
	echo "<br/>";
	
	include("footer.php");
		
?>