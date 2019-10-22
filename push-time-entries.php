<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/conf/Config.php';

use Kenjis\ToggleTimeEntryPusher\Command\PushTimeEntries;
use Kenjis\ToggleTimeEntryPusher\Parser\TextParserJa;
use Kenjis\ToggleTimeEntryPusher\TextProcessorFactory;

$file = $argv[1];

$parser = new TextParserJa();
$factory = new TextProcessorFactory($parser);
$processor = $factory->create();

$command = new PushTimeEntries($processor);
$command->run($file);
