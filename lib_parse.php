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
    return new DateTime(get_element_value($node, 'pubDate'));
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

function get_guid($node){
    return extract_guid_number(get_element_value($node, 'guid'));
}

function get_feed_news($url){
    $doc = new DOMDocument();
    if($doc->load($url) === false){
        die("Error loading feed");
    }

    $xpath = new DOMXPath($doc);

    $news = array();

    foreach( $xpath->query( '//item') as $node){

        // $node is DOMElement
        $nn = new News();
        $nn->title = get_title($node);
        $nn->pubDate = get_pubDate($node);
        $nn->link = get_link($node);
        $nn->guid = get_guid($node);

        $news []= $nn;
    }
    return $news;
}