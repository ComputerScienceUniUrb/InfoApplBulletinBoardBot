<?php
/*
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Main file.
 *
 * SCHEDULE AS CRONJOB
 * EXAMPLE (with parameters set in config.php):
 *      * * * * * php /var/www/public/infoappbb/bot.php>>/tmp/infoappbb/out.log
 * EXAMPLE (with parameters provided as cli options):
 *      * * * * * php /var/www/public/infoappbb/bot.php -f http://example.org -t BOT:TOKEN -c @channelID >>/tmp/infoappbb/out.log
 */

require_once('lib.php');

get_options();

//check news
$news = get_feed_news(FEED_URL);

$new_news = check_new_news($news, FEED_URL);

if (count($new_news) === 0){
    echo "No new news!".PHP_EOL;
} else {

    echo "There are new news!" . PHP_EOL;
    foreach ($new_news as $n) {
        echo "($n->guid) " . $n->toHTML() . PHP_EOL;
        //send news to live channel
        telegram_send_message(LIVE_CHANNEL_ID, $n->toHTML(), array('parse_mode' => "HTML"));
    }
}

save_news(News::toGUIDsArray($news), FEED_URL);
