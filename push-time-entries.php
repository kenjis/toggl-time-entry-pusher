<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/conf/Config.php';

use Kenjis\ToggleTimeEntryPusher\Command\PushTimeEntries;

$file = $argv[1];

$command = new PushTimeEntries();
$command->run($file);
