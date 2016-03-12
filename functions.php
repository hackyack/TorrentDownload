<?php
/**
 * Created by PhpStorm.
 * User: lafer
 * Date: 22-02-16
 * Time: 10:00
 */
include_once('simple_html_dom.php');
define("LASTPAGECPASBIEN", 5);

/* send curl request with name and url of the torrent*/
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

    echo "downloading of file  " . $name;
    if ($curl_errno > 0) {
        echo "cURL Error ($curl_errno): $curl_error\n";
    } else {
        echo "Data received: $data\n";
    }
    echo "<br/>";

    curl_close($ch);
    fclose($fp);
}

/* Replace useless caracter from the name */
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
//testfunction
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
