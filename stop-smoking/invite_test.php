<?php

	require_once("appinclude.php");
	require_once("connection.php");

?>


<?php
	$rs = $facebook->api_client->fql_query("SELECT uid FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1 = $user)"); 
	$arFriends = ""; 
	if ($rs) 
	{ 
		$arFriends .= $rs[0]["uid"]; 
		for ( $i = 1; $i < count($rs); $i++ ) 
		{ 
			if ( $arFriends != "" ) $arFriends .= ","; 
			$arFriends .= $rs[$i]["uid"]; 
		} 
	} // Construct a next url for referrals 
	$sNextUrl = urlencode("&refuid=".$user); // Build your invite text 
$invfbml = <<<FBML 
	You've been invited to join the PickPocket™ Guild! 
	<fb:name uid="$user" firstnameonly="true" shownetwork="false"/> 
	wants you to add PickPocket™ so that you can join 
	<fb:pronoun possessive="true" uid="$user"/> wily band of thieves! 
	<fb:req-choice url="http://www.facebook.com/add.php?api_key=$appapikey&next=$sNextUrl" label="Join the Guild!" /> 
FBML; 
?> 
<fb:request-form type="PickPocket" action="index.php?c=skipped" content="<?=htmlentities($invfbml)?>" invite="true"> 
<fb:multi-friend-selector max="20" actiontext="Here are your friends who don't have PickPocket™. Invite them to play with you!" showborder="true" rows="5" exclude_ids="<?=$arFriends?>"> 
</fb:request-form>