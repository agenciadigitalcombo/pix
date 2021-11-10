<?php

$request = file_get_contents('php://input');
$request = json_decode($request, true) ?? [];

$file_path =  __DIR__ . "/.log";
$content = date("d-m-Y H:i");
$content .= json_encode( array_merge($request, $_REQUEST) );
$content .= " \n";

file_put_contents($file_path, $content, FILE_APPEND);
