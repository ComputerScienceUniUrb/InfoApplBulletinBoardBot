<?php
/*
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Main file.
 *
 * SCHEDULE AS CRONJOB
 * EXAMPLE: * * * * * php /var/www/public/infoappbb/bot.php>>/tmp/infoappbb/out.log
 */

require_once('lib.php');

echo "Hello!".PHP_EOL;

//check news
$news = get_feed_news(FEED_URL);

$new_news = check_new_news($news);

if (count($new_news) === 0){
    echo "No new news!".PHP_EOL;
} else {

    echo "There are new news!" . PHP_EOL;
    foreach ($new_news as $n) {
        echo "($n->guid) " . $n->toHTML() . PHP_EOL;
        //send news to live channel
        telegram_send_message(get_live_channel_id(), $n->toHTML(), array('parse_mode' => "HTML"));
    }
}

save_news(News::toGUIDsArray($news));
