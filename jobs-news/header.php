<?php

	echo "<fb:fbml>";
	
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='padding:10px; height:30px; padding-left:20px; background-color:#FFFFFF; border:1px solid #FFFFFF;'>
			<tr>
				<td style='font-weight:bold; font-size:24px;'>Jobs News</td>
				<td align='right'><img src='".$appcallbackurl."images/nav_logo.gif' /></td>
			</tr>
		</table>";
		
	echo "<br/>";
	echo "<br/>";
	
	$scriptname = basename($_SERVER['PHP_SELF']);
	
	echo "<fb:tabs>";
	if($scriptname == "index.php"){
		echo "	<fb:tab-item href='".$applink."index.php' title='Featured Jobs' selected='true' />";
	}else{
		echo "	<fb:tab-item href='".$applink."index.php' title='Featured Jobs' />";
	}
	
	if($scriptname == "latest.php"){
		echo "	<fb:tab-item href='".$applink."latest.php' title='Latest Employment News' selected='true' />";
	}else{
		echo "	<fb:tab-item href='".$applink."latest.php' title='Latest Employment News' />";
	}
	
	if($scriptname == "invite.php"){
		echo "	<fb:tab-item href='".$applink."invite.php' title='Invite Your Friends' selected='true' />";
	}else{
		echo "	<fb:tab-item href='".$applink."invite.php' title='Invite Your Friends' />";
	}
	
	echo "</fb:tabs>";
	
	echo "<br/>";
	echo "<br/>";

?>