<?php

    $rssContent = file_get_contents("http://jobsindubai.com/rss/rssFeaturedJob.xml");
    
    // echo $rssContent;
    
    $sxml = @simplexml_load_string($rssContent, 'SimpleXMLElement', LIBXML_NOCDATA);
    
    // var_dump($sxml);
    
    // if xml files load fails, show
    if(!$sxml) {
        echo "Error occured. The rss link returns no data.";
    }
    
    // var_dump($sxml);
    // exit;
    $sxml = $sxml->channel;
    
    $feed = array();
    $i = 0;
    
    // iterate over entries in feed
    foreach ($sxml->item as $item) {
        echo $item->title."<br/>";
        $feed[$i]['title'] = (string)$item->title;
        $feed[$i]['link'] = (string)$item->link;
        $feed[$i]['location'] = (string)$item->location;
        $feed[$i]['dated'] = (string)$item->dated;
        $feed[$i]['description'] = (string)$item->description;
        $i += 1;
    }
    
    echo '<pre>';
    print_r($feed);
    echo '</pre>';

?>