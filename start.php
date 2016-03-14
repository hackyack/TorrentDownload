<?php
/**
 * Created by PhpStorm.
 * User: lafer
 * Date: 10-02-16
 * Time: 08:30
 */
ini_set("max_execution_time","70");
include('functions.php');
$arraylink = get_array_links();

$arrayname = get_array_namestorrent($arraylink);
$torrentlinks;
for($cpt=0;$cpt < count($arrayname);$cpt++){
    $torrentlinks[$cpt] = return_torrent_url($arrayname[$cpt]);
}

$nbtorrent = count($arrayname);

for($cpt=0;$cpt<$nbtorrent;$cpt++) {

    echo "<strong>$cpt+1</strong>";
     file_to_dl($arrayname[$cpt], $torrentlinks[$cpt]);



}
