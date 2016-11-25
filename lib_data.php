<?php
/**
 * InfoAppl Bulletin Board Bot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Saving/Reading data function collection.
 */

require_once('lib.php');

function get_news_file_path($feedurl){
    //ex: data/9d8b137f4dd5e03530f69be30ea95bff-data.txt
    return sprintf("%s/%s-data.txt", DATA_BASE_FILEPATH, md5($feedurl));
}

function save_news($news, $feedurl){

    $file_path = get_news_file_path($feedurl);
    $file_path_info = pathinfo($file_path);
    $file_path_dir = $file_path_info['dirname'];

    if (!is_dir($file_path_dir)) {
        mkdir($file_path_dir, 0777, true)
            or die("Cannot create data directory {$file_path_dir}");
    }

    if(!file_exists($file_path)){
        $fh = fopen($file_path, 'a') or die("Cannot create file {$file_path}");
        fwrite($fh, "\n");
        fclose($fh);
    }

    if(!is_writeable($file_path)){
        die("Cannot write file: {$file_path}");
    }

    $sanitized_data  = array_map("sanitize_data_entry", $news);

    $fh = fopen($file_path, 'w') or die("Cannot open file ".$file_path);
    foreach ($sanitized_data as $entry){
        fwrite($fh, $entry."\n") or die("Writing file error ({$file_path})");
    }
    fclose($fh);

}

function read_saved_news($feedurl) {

    $file_path = get_news_file_path($feedurl);

    return is_readable ($file_path)? file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : array();
}

function extract_guid_from_News(News $n){
    return $n->guid;
}

function check_new_news($news_data, $feedurl) {

    //filter out news older than 1 day.
    $news_data = News::filterOutOldNewsArray($news_data);

    $news = News::toGUIDsArray($news_data);
    $old_news = read_saved_news($feedurl);

    if($old_news === FALSE){
        die("Reading file error");
    }

    $sanitized_old_news  = array_map("sanitize_data_entry", $old_news);
    $sanitized_news  = array_map("sanitize_data_entry", $news);

    $new_news = array();
    foreach ($sanitized_news as $key => $n){
        if(!in_array($n, $sanitized_old_news)){
            $new_news[] = $news_data[$key];
        }
    }

    return $new_news;
}

function sanitize_data_entry($entry) {
    return str_replace("\n",' ',rtrim(ltrim(strtolower($entry))));
}