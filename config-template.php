<?php
/*
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Configuration file.
 * If you intend to execute the bot.php script with options specified
 * as command line options, then you don't need to change anything here.
 *
 * If you want to execute the script without have to specify
 * the requested parameters all the times, than you can set
 * the parameters here filling in values and uncommenting each row.
 * Then please save this file as config.php
 *
 * In the latter case:
 * DO NOT COMMIT CONFIG.PHP.
 */

require_once ('vendor/autoload.php');

/*  The Telegram bot's token  (can be generated via https://telegram.me/BotFather)*/
//define('TELEGRAM_BOT_TOKEN', ''); //Leave as it is or set and uncomment.

/*  RSS/FEED URL from which the news are taken */
//define('FEED_URL', '');           //Leave as it is or set and uncomment.

/*  Telegram Live Channel where the news are sent */
//define('LIVE_CHANNEL_ID', '');    //Leave as it is or set and uncomment.

/*  Constants for Data Access */
define('DATA_BASE_FILEPATH', 'data');

/*********************************
 * DO NOT MODIFY BELOW THIS LINE *
 *********************************/

function get_options()
{
    $cmd = new Commando\Command();

    // Require bot's token
    if(!defined('TELEGRAM_BOT_TOKEN'))
    $cmd->option('t')
        ->require()
        ->aka('token')
        ->describedAs('The bot\'s token')
        ->must(function ($token) {
            return strlen($token) > 10 && strpos($token, ':') > 0;
        });

    // Require feed url
    if(!defined('FEED_URL'))
        $cmd->option('f')
        ->require()
        ->aka('feed')
        ->describedAs('The feed URL')
        ->must(function ($feed) {
            // let's do not restrict this too much
            // just in case we need to load a local feed file.
            return strlen($feed) > 5;
        });

    // Require telegram channel ID
    if(!defined('LIVE_CHANNEL_ID'))
    $cmd->option('c')
        ->require()
        ->aka('channel')
        ->describedAs('The Telegram channel ID')
        ->must(function ($channelID) {
            return starts_with($channelID, "@") && strlen($channelID) > 5;
        });

    // set help
    $cmd->setHelp("This script fetches news from a feed and send them to a Telegram channel.".PHP_EOL.PHP_EOL.
        "Mandatory parameters (bot's token, feed url and telegram channel ID)".PHP_EOL.
        "could be provided as cli arguments like:".PHP_EOL.
        "  $ php bot.php -f http://example.org -t BOT:TOKEN -c @channelID".PHP_EOL.
        "(see below for more details about options)".PHP_EOL.
        "or you can set each parameter in the config.php file and execute as:".PHP_EOL.
        "  $ php bot.php".PHP_EOL);

    if(!defined('TELEGRAM_BOT_TOKEN')){ define('TELEGRAM_BOT_TOKEN', $cmd['token']); }
    if(!defined('FEED_URL')){ define('FEED_URL',$cmd['feed']); }
    if(!defined('LIVE_CHANNEL_ID')){ define('LIVE_CHANNEL_ID', $cmd['channel']); }
    //echo "BOT:{$cmd['token']} FROM:{$cmd['feed']} TO:{$cmd['channel']}" . PHP_EOL;

    /*  Constants for telegram API */
    define('TELEGRAM_BOT_NAME', 'InfoApp_BulletinBoard_bot');
    define('TELEGRAM_API_URI_BASE', 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/');
    define('TELEGRAM_API_URI_FILE', 'https://api.telegram.org/file/bot' . TELEGRAM_BOT_TOKEN . '/');
    define('TELEGRAM_API_URI_ME', TELEGRAM_API_URI_BASE . 'getMe');
    define('TELEGRAM_API_URI_MESSAGE', TELEGRAM_API_URI_BASE . 'sendMessage');
    define('TELEGRAM_API_URI_LOCATION', TELEGRAM_API_URI_BASE . 'sendLocation');
    define('TELEGRAM_API_URI_PHOTO', TELEGRAM_API_URI_BASE . 'sendPhoto');
    define('TELEGRAM_API_URI_UPDATES', TELEGRAM_API_URI_BASE . 'getUpdates');
    define('TELEGRAM_API_URI_FILE_PATH', TELEGRAM_API_URI_FILE . 'getFile');
    define('TELEGRAM_DEEP_LINK_URI_BASE', 'https://telegram.me/' . TELEGRAM_BOT_NAME . '?start=');

}
?>
