<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/conf/Config.php';

use Kenjis\ToggleTimeEntryPusher\Command\PushTimeEntries;
use Kenjis\ToggleTimeEntryPusher\Parser\TextParserJa;

$file = $argv[1];

$parser = new TextParserJa();
$command = new PushTimeEntries($parser);
$command->run($file);
