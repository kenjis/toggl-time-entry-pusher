<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/conf/Config.php';

use Kenjis\ToggleTimeEntryPusher\Command\GetProjectList;
use Kenjis\ToggleTimeEntryPusher\Toggl\ProjectFetcher;
use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://www.toggl.com/api/v8/',
]);
$fetcher = new ProjectFetcher(
    $client,
    Config::WID,
    Config::API_KEY
);

$command = new GetProjectList($fetcher);
$command->run();
