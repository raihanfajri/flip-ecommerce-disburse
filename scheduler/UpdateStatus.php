<?php

require_once __DIR__ . "/../helpers/Http/Curl/Client.php";
require_once __DIR__ . "/../helpers/Log.php";
require_once __DIR__ . "/../helpers/Constants/DisburseConstant.php";

use helpers\Constants\DisburseConstant;
use helpers\Http\Curl\Client;
use helpers\Log;

$today = Date("Y-m-d");
$log_name = "scheduler-$today.log";

Log::info("Scheduler starting....", $log_name);

$client = new Client("localhost:3005", "/api/disburse/list", "GET");
$client->intialize(['status' => DisburseConstant::STATUS_PENDING]);
$client->callEndpoint();

$body = json_decode($client->respBody(), true);

if (empty($body)) {
    Log::info("Failed to get pending list", $log_name);
    die();
}

if (!$body['success']) {
    Log::info("Failed to get pending list. reason : " . $body['message'], $log_name);
    die();
}

if (empty($body['data'])) {
    Log::info("Nothing is processed");
    die();
}

Log::info(count($body['data']) . " data will be processed", $log_name);

$client_update = new Client("localhost:3005", "/api/disburse", "PATCH");

$list = $body['data'];

foreach ($list as $data) {
    $id = $data['id'];

    $client->intialize(['id' => $id]);
    $client->callEndpoint();
    $body = json_decode($client->respBody(), true);

    if (empty($body)) {
        Log::info("ID #$id Failed to update status. ID #$id", $log_name);
    }
    
    if (!$body['success']) {
        Log::info("ID #$id Failed to update status. reason : " . $body['message'], $log_name);
    }

    $status = $body['data']['status'] ?? DisburseConstant::STATUS_PENDING;

    if ($status != DisburseConstant::STATUS_PENDING) {
        Log::info("ID #$id Updated status to $status. reason : " . $body['message'], $log_name);
    }
    else {
        Log::info("ID #$id status still $status.", $log_name);
    }
    
}

Log::info("Scheduler end....", $log_name);