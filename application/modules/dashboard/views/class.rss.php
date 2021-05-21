<?php
 class rss {
	var $feed;

	function rss($feed) 
	{
		$this->feed = $feed;  
	}

	private function parseFlux() 
    {
		$rss = simplexml_load_file($this->feed);

	    $rss_split = array();

	    foreach ($rss->channel->item as $item) {
		    $title  	 = (string) $item->title; // Title
		    $link   	 = (string) $item->link; // Url Link
		    $description = (string) $item->description; //Description
		    $rss_split[] = '<div class="bloc-title-link"><a href="'.$link.'" target="_blank" title="" >'.$title.'</a><span class="light-text">'.$description.'</span></div>';
    	}

    	return $rss_split;
	}

	function displayFlux($numrows,$head) 
	{

	    $rss_split = $this->parseFlux();

	    if (($rss_split))
	    {
	    	$totalFeed = count($rss_split);
		    if ($numrows > $totalFeed) {
		    	$numrows = $totalFeed;
		    }
		    $i = 0;
		    $rss_data = '<div class="bloc">
		           <div class="bloc-head">
		         '.$head.'
		           </div>
		         <div class="bloc-title autoplay">';
		    while ( $i < $numrows ) 
		   	{
		      $rss_data .= $rss_split[$i];
		      $i++;
		    }

		    $rss_data.='</div></div>';
	    }

	    return $rss_data;
  	}
}
?>