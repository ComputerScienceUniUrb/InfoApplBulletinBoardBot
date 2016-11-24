<?php

/**
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * News class.
 */
class News
{
    public $guid;
    public $date;
    public $link;
    public $title;
    public $pubDate;

    function toHTML() {
        return sprintf("<b>%s</b>\n<a href=\"%s\">link</a>", $this->title, $this->link);
    }

    function isStillFresh(News $news = null){

        $pd = is_null($news) ? $this->pubDate : $news->pubDate;

        $today = new DateTime();
        $diff = $today->diff($pd);
        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);

        return $hours < 24;
    }

    public static function extractGUID(News $n){
        return $n->guid;
    }

    public static function toGUIDsArray($NewsArray){
            return array_map(array("News", "extractGUID"), $NewsArray);
    }

    public static function filterOutOldNewsArray($news_array){
        $news = array();
        foreach ($news_array as $n) {
           if($n->isStillFresh()){
               $news[] = $n;
           }
        }
        return $news;
    }
}