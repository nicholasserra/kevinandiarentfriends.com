<?php                                                


class Rss extends Controller {

    function Rss()
    {
        parent::Controller();
    }
    
    function index()
    {
        $this->load->model('Kevin');
        
        $items = $this->Kevin->grab_tweets();
        
        
        $time = time();
        $output = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <rss version="2.0">
            <channel>
                <title>Kevin and I aren't friends</title>
                <link>http://www.kevinandiarentfriends.com</link>
                <description>Many reasons why Nick Serra and Kevin Krpicak are not friends.</description>
                <language>en-us</language>
                <pubDate>$time</pubDate>

                <lastBuildDate>$time</lastBuildDate>
                <webMaster>nicks@ydekproductions.com</webMaster>
XML;

        for($i = 0; $i < count($items); $i++)
        {
            $text = $items[$i]['message'];
            $date = date('F jS, Y', $items[$i]['timestamp']);;

        $output .= <<<XML
            <item>
                <title>$text</title>
                <pubDate>$date</pubDate>
            </item>
XML;
        }

        $output .= <<<XML
            </channel>
        </rss>
XML;
        
        header("Content-Type: application/rss+xml; charset=ISO-8859-1");
        echo $output;
    }
}
