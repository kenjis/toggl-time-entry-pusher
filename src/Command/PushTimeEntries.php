<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Command;

use Config;
use GuzzleHttp\Client;
use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;
use Kenjis\ToggleTimeEntryPusher\LineOutputter;
use Kenjis\ToggleTimeEntryPusher\Parser\TextParserJa;
use Kenjis\ToggleTimeEntryPusher\TextProcessor;
use Kenjis\ToggleTimeEntryPusher\TimeEntryFactory;
use Kenjis\ToggleTimeEntryPusher\Toggl\TimeEntryPusher;

class PushTimeEntries
{
    public function run(string $file) : void
    {
        if (! is_readable($file)) {
            throw new RuntimeException('Cannot read file: ' . $file);
        }

        $parser = new TextParserJa();
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => Config::TOGGL_BASE_URL,
        ]);
        $outputter = new LineOutputter();
        $pusher = new TimeEntryPusher(
            $client,
            Config::API_KEY,
            $outputter
        );
        $factory = new TimeEntryFactory(
            Config::PID_MAP,
            Config::TAG_MAP
        );
        $processor = new TextProcessor(
            $parser,
            $factory,
            $pusher,
            $outputter
        );

        $updatedText = $processor->process(file_get_contents($file));
        $updatedText = trim($updatedText) . "\n";
        file_put_contents($file, $updatedText, LOCK_EX);
    }
}
