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