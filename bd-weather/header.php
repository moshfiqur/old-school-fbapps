<?php

	echo "<fb:fbml>";
	
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='padding:10px; height:30px; padding-left:20px; background-color:#FFFFFF; border:1px solid #FFFFFF;'>
			<tr>
				<td><img src='" . $appcallbackurl . "images/main-banner.jpg' border='0' width='600' height='230' /></td>
			</tr>
		</table>";
		
	echo "<br/>";
	echo "<br/>";
	
	$scriptname = basename($_SERVER['PHP_SELF']);
	
	echo "<fb:tabs>";
	if($scriptname == "index.php"){
		echo "	<fb:tab-item href='".$applink."index.php' title='Home' selected='true' />";
	}else{
		echo "	<fb:tab-item href='".$applink."index.php' title='Home' />";
	}
	
	if($scriptname == "invite.php"){
		echo "	<fb:tab-item href='".$applink."invite.php' title='Invite Your Friends' selected='true' />";
	}else{
		echo "	<fb:tab-item href='".$applink."invite.php' title='Invite Your Friends' />";
	}
        
        if($scriptname == "warning.php"){
		echo "	<fb:tab-item href='".$applink."warning.php' title='Warning!' selected='true' />";
	}else{
		echo "	<fb:tab-item href='".$applink."warning.php' title='Warning!' />";
	}
	
	echo "</fb:tabs>";
	
	echo "<br/>";
	echo "<br/>";

?>