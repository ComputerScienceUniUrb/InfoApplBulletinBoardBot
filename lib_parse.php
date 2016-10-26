<?php
/**
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Parsing function collection.
 */

function get_element_value($node, $nodeTag){
    $elNodes = $node->GetElementsByTagName($nodeTag);
    if( $elNodes->length < 1){
        die("Parsing Error");
    }
    return $elNodes->item(0)->nodeValue;
}

function get_title($node){
    return get_element_value($node, 'title');
}

function get_pubDate($node){
    return get_element_value($node, 'pubDate');
}

function get_link($node){
    return get_element_value($node, 'link');
}

function get_description($node){
    return get_element_value($node, 'description');
}

function get_content_encoded($node){
    return get_element_value($node, 'encoded');
}

function get_feed_news($url){
    $doc = new DOMDocument();
    $doc->load($url);

    $xpath = new DOMXPath($doc);

    $news = array();
    $news_data = array();
    foreach( $xpath->query( '//item') as $node){
        // $node is DOMElement

        $title = get_title($node);
        //$pubDate = get_pubDate($node);
        $link = get_link($node);

        $news_data []= format_news_HTML($title, $link);
        //echo format_news_HTML($title, $link, $content).PHP_EOL;
    }
    return $news_data;
}