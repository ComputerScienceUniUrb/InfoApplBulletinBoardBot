<?php
/**
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Saving/Reading data function collection.
 */

require_once('lib.php');

function save_news($news){

    if(!file_exists(DATA_FILE)){
        $fh = fopen(DATA_FILE, 'a') or die("Cannot create file");
        fwrite($fh, "\n");
        fclose($fh);
    }

    $sanitized_data  = array_map("sanitize_data_entry", $news);

    $fh = fopen(DATA_FILE, 'w') or die("Cannot open file");
    foreach ($sanitized_data as $entry){
        fwrite($fh, $entry."\n") or die("Writing file error");
    }
    fclose($fh);

}

function read_saved_news() {
    return file(DATA_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function extract_guid_from_News(News $n){
    return $n->guid;
}

function check_new_news($newsData) {

    $news = News::toGUIDsArray($newsData);
    $old_news = read_saved_news();

    if($old_news === FALSE){
        die("Reading file error");
    }

    $sanitized_old_news  = array_map("sanitize_data_entry", $old_news);
    $sanitized_news  = array_map("sanitize_data_entry", $news);

    $new_news = array();
    foreach ($sanitized_news as $key => $n){
        if(!in_array($n, $sanitized_old_news)){
            $new_news[] = $newsData[$key];
        }
    }

    return $new_news;
}

function sanitize_data_entry($entry) {
    return str_replace("\n",' ',rtrim(ltrim(strtolower($entry))));
}