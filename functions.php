<?php
/**
 * Created by PhpStorm.
 * User: lafer
 * Date: 22-02-16
 * Time: 10:00
 */
include_once('simple_html_dom.php');
define("LASTPAGECPASBIEN", 5);

function file_to_dl($name, $url)
{
    $path = "./torrentsfile/" . $name . ".torrent";
    echo $path . '<br/>';
    echo $url . '<br/>';
    $fp = fopen($path, 'x');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);

    echo "téléchargement du fichier " . "<strong>" . $name . "</strong>";
    if ($curl_errno > 0) {
        echo "cURL Error ($curl_errno): $curl_error\n";
    } else {
        echo "Data received: $data\n";
    }
    echo "<br/>";

    curl_close($ch);
    fclose($fp);
}

function testdown($urls)
{

    $save_to = './torrentsfile/';

    $mh = curl_multi_init();
    foreach ($urls as $i => $url) {
        $g = $save_to . basename($url);
        if (!is_file($g)) {
            $conn[$i] = curl_init($url);
            $fp[$i] = fopen($g, "w");
            curl_setopt($conn[$i], CURLOPT_FILE, $fp[$i]);
            curl_setopt($conn[$i], CURLOPT_HEADER, 0);
            curl_setopt($conn[$i], CURLOPT_CONNECTTIMEOUT, 60);
            curl_multi_add_handle($mh, $conn[$i]);
        }
    }
    do {
        $n = curl_multi_exec($mh, $active);
    } while ($active);
    foreach ($urls as $i => $url) {
        curl_multi_remove_handle($mh, $conn[$i]);
        curl_close($conn[$i]);
        fclose($fp[$i]);
    }
    curl_multi_close($mh);

}

function format_name($name){
        $tmpname = str_replace("-"," ",$name);
        $tmpname2 =  str_replace("french"," ",$tmpname);

        return $newname;
}
function return_torrent_url($nametorrent)
{

    $tmpname = strtolower($nametorrent);
    $url = 'http://www.cpasbien.io/telechargement/' . $tmpname . '.torrent';
    return $url;
}

function get_array_links()
{
    $npage = 0;
    $nlink = 0;
    for ($npage; $npage < LASTPAGECPASBIEN; $npage++) {

        $page = 'http://www.cpasbien.io/view_cat.php?categorie=films&page=' . $npage;
        $html = file_get_html($page);
        foreach ($html->find('div.ligne1 a') as $element) {
            $links[$nlink] = $element->href;
            $nlink++;
        }
    }
    return $links;
}

function get_array_namestorrent($links)
{
    $nlink = count($links);
    $cpt = 0;
    for ($cpt; $cpt < $nlink; $cpt++) {
        $tmpstring = after_last("/", $links[$cpt]);
        $newstring = before_last(".", $tmpstring);
        $names[$cpt] = $newstring;
    }
    return $names;
}

function show($links)
{
    $nlink = count($links);
    $cpt = 0;
    for ($cpt; $cpt < $nlink; $cpt++) {

        echo "<br/>" . $links[$cpt];
    }
}

function after_last($this, $inthat)
{
    if (!is_bool(strrevpos($inthat, $this)))
        return substr($inthat, strrevpos($inthat, $this) + strlen($this));
}

;
function before_last($this, $inthat)
{
    return substr($inthat, 0, strrevpos($inthat, $this));
}

;
function strrevpos($instr, $needle)
{
    $rev_pos = strpos(strrev($instr), strrev($needle));
    if ($rev_pos === false) return false;
    else return strlen($instr) - $rev_pos - strlen($needle);
}

;