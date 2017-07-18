<?php

	require_once("appinclude.php");
	require_once("connection.php");

?>


<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
	include("header.php");
	
	$content = htmlentities("Encourage your friends to leave smoking by sending invitation to join here. Help them to live a longer and happier life. <fb:req-choice url=\"http://apps.facebook.com/stop-smoking/\" label=\"Encourage your friends\" />");
	
	echo "<fb:request-form action='invite.php' method='POST' invite='true' type='StopSmoking' content='$content'>";
	echo "	<fb:multi-friend-selector showborder='false' max='20' actiontext='Encourage Your Friends.'>";
	echo "</fb:request-form>";
				  
	include("footer.php");
		
?>