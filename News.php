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

    function isStillFresh(){
        $today = new DateTime();
        $diff = $today->diff($today);
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

    public static function toGUIDsArray2($NewsArray){
        return array_map(function($n) {return $n->guid;}, $NewsArray);
    }

}