<?php

$URL_API = "https://api.zoop.ws";
$key_zpk = "zpk_prod_77hQAABdrBzAKVr8cZuaHWk8" . ":";
$mkt_id =  "7e704295b1ba41e88574e24830d5369a";

$_REQUEST['behalf'] = empty($_REQUEST['behalf']) ? "8afba79148464ca7a1833676058eb052" : $_REQUEST['behalf'];
$_REQUEST['amount'] = empty($_REQUEST['amount']) ? "5000" : $_REQUEST['amount'];

$behalf = $_REQUEST['behalf'];
$amount = $_REQUEST['amount'];

$full_url = $URL_API . "/v1/marketplaces/" . $mkt_id . '/transactions';

$params = [
    "on_behalf_of" => $behalf,
    "amount" => intval($amount),
    "payment_type" => "pix",
    "currency" => "BRL",
    "description" => "Venda com Pix"
];

$defaults = [
    CURLOPT_POST           => true,
    CURLOPT_HEADER         => false,
    CURLOPT_URL            => $full_url,
    CURLOPT_FRESH_CONNECT  => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FORBID_REUSE   => true,
    CURLOPT_TIMEOUT        => 12,
    CURLOPT_POSTFIELDS     => http_build_query($params),
    CURLOPT_USERPWD        => $key_zpk,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HTTPHEADER     => [
        "Content-Type" => "application/json; charset=UTF-8",
        "accept" => "application/json"
    ]
];
$ch = curl_init();
curl_setopt_array($ch, $defaults);
$result = curl_exec($ch);
curl_close($ch);

$parse_json = json_decode($result);

if (!empty($parse_json->error)) {

    echo json_encode([
        "next" => false,
        "message" => $parse_json->error->message,
        "qr_code" => null
    ]);
    die;
}

echo json_encode([
    "next" => true,
    "message" => "PIX gerado com sucesso",
    "qr_code" => $parse_json->payment_method->qr_code->emv
]);
