<?php

/*This script pulls the title from a CL Network Page */

   function page_title($url) {
        $fp = file_get_contents($url);
        if (!$fp) 
            return null;

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) 
            return null; 

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
  
        //Get rid of specific words
        $title = str_replace('Network Graph of ', "", $title);
        $title = substr($title, 0, strlen($title)-22);

        return $title;
    }

$myTitle = page_title('https://www.courtlistener.com/visualizations/scotus-mapper/1101/anderson-1987-to-white-2017/');
echo $myTitle;
?>
