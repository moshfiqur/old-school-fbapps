<?php

	require_once("appinclude.php");
	require_once("connection.php");	

?>

<?php
	
	######################################################################################################################################################
	## MAIN APPLICATION BODY PART
	######################################################################################################################################################
	$rssContent = file_get_contents("http://jobsindubai.com/rss/rssLatestNews.xml");
	
	$rss = @simplexml_load_string($rssContent, 'SimpleXMLElement', LIBXML_NOCDATA);
	
	// if xml files load fails, show
	if(!$rss) {
		$fbml = "Error occured. The rss link returns no data.";
	}
	
	$fbml = '<div style="margin:0 10px 0 10px;">';
	$fbml .= '
		<table border="0" width="100%" style="margin: 5px 5px 5px 5px;">
			<tr>
				<td valign="top" width="80%">
					<a href="'.$rss->channel->link.'" style="font-weight: bold; font-size:16px;">'.$rss->channel->title.'</a>
				</td>
				<td valign="top" width="80%">
					<fb:share-button class="meta">
						<meta name="medium" content="blog"/>
						<meta name="title" content="'.htmlspecialchars(strip_tags($rss->channel->title)).'"/>
						<meta name="description" content="'.htmlspecialchars(strip_tags($rss->channel>description)).'"/>
						<link rel="target_url" href="'.$rss->channel->link.'"/>
					</fb:share-button>
				</td>
			</tr>
		</table>';
		
	$rss = $rss->channel;
	
	foreach ($rss->item as $item) {
		$fbml .= '
			<div style="border-bottom: 2px solid #CCCCCC; padding-bottom:5px;"><br/>
				<div style="border-bottom: 1px dotted #CCCCCC; border-top: 1px dotted #CCCCCC;">
					<table border="0" width="100%" style="margin: 5px 5px 5px 5px;">
						<tr>
							<td valign="top" width="80%"><a href="'.$item->link.'" style="font-weight: bold;">'.$item->title.'</a></td>
							<td valign="top" width="80%">
								<fb:share-button class="meta">
									<meta name="medium" content="blog" />
									<meta name="title" content="'.htmlspecialchars(strip_tags($item->title)).'" />
									<meta name="description" content="'.htmlspecialchars(strip_tags($item->description)).'" />
									<link rel="target_url" href="'.$item->link.'" />
								</fb:share-button>
							</td>
						</tr>
					</table>
				</div>';
		if($item->description) {
			$fbml .= $item->description;
		}
		$fbml .= '</div>';
	}
	$fbml .= '</div>';
	
	//$facebook->api_client->profile_setFBML($fbml, $user);
	include("header.php");
	
	echo $fbml;
	
	echo "<br/>";
	echo "<br/>";
	
	include("footer.php");
		
?>