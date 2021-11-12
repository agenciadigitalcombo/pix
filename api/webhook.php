<?php

header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');
date_default_timezone_set('America/Sao_Paulo');

$request = file_get_contents('php://input');
$request = json_decode($request, true) ?? [];

$file_path =  __DIR__ . "/.log";
$content = date("d-m-Y H:i");
$content .= json_encode( array_merge($request, $_REQUEST) );
$content .= " \n";

file_put_contents($file_path, $content, FILE_APPEND);

echo json_encode([
    "next" => true,
    "message" => "Web Hook recebido com sucesso"
]);