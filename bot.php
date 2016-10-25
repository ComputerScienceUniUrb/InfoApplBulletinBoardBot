<?php
/*
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Main file.
 *
 * SCHEDULE AS CRONJOB
 */

require_once('lib.php');

echo "Hello!".PHP_EOL;

//check news
$doc = new DOMDocument();
$doc->load(FEED_URL);

$xpath = new DOMXPath($doc);

$news = array();
$news_data = array();
foreach( $xpath->query( '//item') as $node){
    // $node is DOMElement

    $title = get_title($node);
    $pubDate = get_pubDate($node);
    $link = get_link($node);
    $description = get_description($node);
    $content = get_content_encoded($node);

    $news []= "$title ($pubDate)";
    //echo "$title ($pubDate)".PHP_EOL;
    $news_data []= format_news_HTML($title, $link, $description);
    //echo format_news_HTML($title, $link, $content).PHP_EOL;
}

$new_idx = check_new_news($news);

if($new_idx === FALSE){
    echo "No new news!".PHP_EOL;
    exit(0);
}

echo "There is new news!".PHP_EOL;
print_r($news_data[$new_idx]);
echo PHP_EOL;

//send news to live channel
telegram_send_message(LIVE_CHANNEL_ID, $news_data[$new_idx], array('parse_mode'=> "HTML"));

save_news($news);


function format_news_HTML($title, $link, $content) {
    return sprintf("<b>%s</b>\n%s\n<a href=\"%s\">link</a>", $title, $content, $link);
}