<?php

	require_once("appinclude.php");
	require_once("connection.php");

?>


<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	
	include("header.php");
	
	$content = '<b>THERE IS NO WARNING FOR MARITIME PORTS.</b><br/><br/><br/><br/><br/><br/>
                    <div style="font-size:smaller">Date: Octber 11, 2009 Issue time:1000 BST</div>
                    <div style="font-size:smaller">Source: <a href="http://www.bmd.gov.bd" target="_BLANK">National Web Portal of Bangladesh</a></div>                    ';
        
        echo $content;
	
	include("footer.php");
?>