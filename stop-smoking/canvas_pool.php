<?php

	require_once("appinclude.php");
	require_once("connection.php");
	
	if(isset($_REQUEST['save'])){
		
		$canvas = $_REQUEST['canvas'];
		$profile = $_REQUEST['profile'];
		
		$sql1 = "SELECT uid FROM fb_ss_user WHERE uid = '$user'";
		$result1 = mysql_query($sql1);
		if(mysql_num_rows($result1)){
			$sql = "UPDATE fb_ss_user SET canvas = '$canvas', profile = '$profile' WHERE uid = '$user'";
			$result = mysql_query($sql);
		}else{
			$sql = "INSERT INTO fb_ss_user (rid, uid, canvas, profile) values (null, '$user', '$canvas', '$profile')";
			$result = mysql_query($sql);
		}
	
	}
	
	$img_array_box = "
						<form method='post' action='canvas_pool.php'>
						<table width='100%' border='0' cellspacing='0' cellpadding='5' style='border-top:1px solid #3B5998; border-bottom:1px solid #3B5998; border-left:1px solid #B7B7B7; border-right:1px solid #B7B7B7;' align='center'>
					";
	
	$sql = "SELECT * FROM fb_ss_image_pool";
	$result = mysql_query($sql);
	$is_first = true;
	$css = "bgcolor='#CCCCCC'";
	$i = 1;
	while($row = mysql_fetch_array($result)){
		if($is_first){
			$img_array_box .= "
				<tr>
					<td " . $css . "><img src='" . $appcallbackurl . "images/thumbs/" . $row['image_name'] . "' style='border:1px solid #3B5998;' border='0' width='200' /></td>
					<td " . $css . "><input type='radio' name='canvas' id='canvas[$i]' value='" . $row['image_id'] . "' checked='checked' /> Set to Canvas</td>
					<td " . $css . "><input type='radio' name='profile' id='profile[$i]' value='" . $row['image_id'] . "' checked='checked' /> Set to Profile</td>
				</tr>";
			$is_first = false;
		}else{
			$img_array_box .= "
				<tr>
					<td " . $css . "><img src='" . $appcallbackurl . "images/thumbs/" . $row['image_name'] . "' style='border:1px solid #3B5998;' border='0' width='200' /></td>
					<td " . $css . "><input type='radio' name='canvas' id='canvas[$i]' value='" . $row['image_id'] . "' /> Set to Canvas</td>
					<td " . $css . "><input type='radio' name='profile' id='profile[$i]' value='" . $row['image_id'] . "' /> Set to Profile</td>
				</tr>";
		}
		$i += 1;
		if($i % 2 == 0){
			$css = "bgcolor='#BBBBBB'";
		}else{
			$css = "bgcolor='#CCCCCC'";
		}
	}
	
	$img_array_box .= "
			<tr>
				<td colspan='3'><input type='submit' name='save' id='save' value='Save' /></td>
			</tr>
		</table>
		</form>";
				
?>

<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
	include("header.php");
	
	echo "<table width='600' border='0' cellspacing='0' cellpadding='3' style='border:5px solid #E90512;' align='center'>
				  <tr>
					<td style='color:#333333; font-weight:bold; font-size:12px;'>Choose one image. This image will be shown on this application canvas when you logged in.</td>
				  </tr>
				  <tr>
					<td style='font-size:24px; font-weight:bold; color:#E90512; padding:10px;'>$img_array_box</td>
				  </tr>
			   </table>";
	
	echo "<br/>";
	echo "<br/>";
	
	include("footer.php");
		
?>