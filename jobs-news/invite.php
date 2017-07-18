<?php

	require_once("appinclude.php");
	require_once("connection.php");

?>


<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
	include("header.php");
	
	$content = htmlentities("Come and join. Get instant jobs news <fb:req-choice url=\"http://apps.facebook.com/jobs-news/\" label=\"Confirm\" />");
	
	// this is the form to send invitation, type is the button text shows below this form. This will be "Send BD Weather Invitation". The "Send" and 
	// "Invitation" word will be added by facebook
	echo "<fb:request-form action='invite.php' method='POST' invite='true' type='Jobs News' content='$content'>";
	echo "	<fb:multi-friend-selector showborder='false' max='20' actiontext='Invite Your Friends.'>";
	echo "</fb:request-form>";
				  
	include("footer.php");
		
?>