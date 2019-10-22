<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use Config;
use GuzzleHttp\Client;
use Kenjis\ToggleTimeEntryPusher\Parser\ParserInterface;
use Kenjis\ToggleTimeEntryPusher\TimeEntry\TimeEntryFactory;
use Kenjis\ToggleTimeEntryPusher\Toggl\TimeEntryPusher;

class TextProcessorFactory
{
    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function create() : TextProcessor
    {
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

        return new TextProcessor(
            $this->parser,
            $factory,
            $pusher,
            $outputter
        );
    }
}
