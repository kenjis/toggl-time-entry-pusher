<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/conf/Config.php';

use GuzzleHttp\Client;
use Kenjis\ToggleTimeEntryPusher\Toggl\ProjectFetcher;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://www.toggl.com/api/v8/',
]);
$fetcher = new ProjectFetcher(
    $client,
    Config::WID,
    Config::API_KEY
);

$response = $fetcher->fetch();
$jsonString = $response->getBody()->getContents();
$list = json_decode($jsonString, true);

foreach ($list as $project) {
    foreach ($project as $key => $val) {
        printf('%14s: %s' . PHP_EOL, $key, $val);
    }
    echo PHP_EOL;
}
