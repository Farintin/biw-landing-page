<?php

$fp = fopen("msg.json", "r") or die("Unable to open file!");

$msg = fread($fp, filesize("msg.json"));
//header('Content-type: application/json');
echo $msg;

fclose($fp);

?>