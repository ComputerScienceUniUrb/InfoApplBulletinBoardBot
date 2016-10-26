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
$news_it = get_feed_news(FEED_IT_URL);
$news_en = get_feed_news(FEED_EN_URL);

$news = array_merge($news_it, $news_en);

$new_news = check_new_news($news);

if(count($new_news) === 0){
    echo "No new news!".PHP_EOL;
    exit(0);
}

echo "There is new news!".PHP_EOL;
foreach ($new_news as $n) {
    print_r($n);
    echo PHP_EOL;
    //send news to live channel
    telegram_send_message(get_live_channel_id(), $n, array('parse_mode' => "HTML"));
}
save_news($news);


function format_news_HTML($title, $link) {
    return sprintf("<b>%s</b>\n<a href=\"%s\">link</a>", $title, $link);
}