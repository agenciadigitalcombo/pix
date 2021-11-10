<?php

/**
 * @dev
 * MKT_ID: 83824523b30a4f44a6231c46319c8c12
 * KEY_ZPK: zpk_test_lcyUVmcv7ISdesnZe4m3w5eN
 * SELER_ID: 6cf4bb1e78c6428786fc8fe6ddada3a6
 * 
 * @prod
 * MKT_ID: 7e704295b1ba41e88574e24830d5369a
 * KEY_ZPK: zpk_prod_77hQAABdrBzAKVr8cZuaHWk8
 */

$URL_API = "https://api.zoop.ws";
$key_zpk = "zpk_test_lcyUVmcv7ISdesnZe4m3w5eN";
$mkt_id = "83824523b30a4f44a6231c46319c8c12";

$full_url = $URL_API . "/v1/marketplaces/" . $mkt_id . '/transactions';

$_REQUEST['mkt_id'] = "6cf4bb1e78c6428786fc8fe6ddada3a6";
$_REQUEST['amount'] = "5000";

$params = [
    "on_behalf_of" => $_REQUEST['mkt_id'],
    "currency" => "BRL",
    "amount" => $_REQUEST['amount'],
    "payment_type" => "pix"
];

$defaults = [
    CURLOPT_POST           => true,
    CURLOPT_HEADER         => false,
    CURLOPT_URL            => $full_url,
    CURLOPT_FRESH_CONNECT  => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FORBID_REUSE   => true,
    CURLOPT_TIMEOUT        => 12,
    CURLOPT_POSTFIELDS     => json_encode( $params ),
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
$result = json_decode($result);
echo $result;
