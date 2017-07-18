<?php

	require_once("appinclude.php");
	require_once("connection.php");	

?>

<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
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
	
	echo "<table width='600' border='0' cellspacing='0' cellpadding='3' style='border:5px solid #E90512;' align='center'>
				  <!--<tr>
					<td style='color:#333333; font-weight:bold; font-size:14px;'>Today's Quote</td>
				  </tr>-->
				  <tr>
					<td align='center' style='padding:10px;'><img src='" . $appcallbackurl . "images/canvas-1.jpg' border='0' /></td>
				  </tr>
			   </table>";
	
	echo "<br/>";
	echo "<br/>";
	
	include("footer.php");
		
?>