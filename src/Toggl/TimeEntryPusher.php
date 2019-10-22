<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Toggl;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Kenjis\ToggleTimeEntryPusher\LineOutputter;
use Kenjis\ToggleTimeEntryPusher\TimeEntry;

class TimeEntryPusher
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiToken;

    /**
     * @var LineOutputter
     */
    private $outputter;

    public function __construct(Client $client, string $apiToken, LineOutputter $outputter)
    {
        $this->client = $client;
        $this->apiToken = $apiToken;
        $this->outputter = $outputter;
    }

    public function push(TimeEntry $entry) : bool
    {
        // https://github.com/toggl/toggl_api_docs/blob/master/chapters/time_entries.md
        $uri = 'time_entries';

        $entryArray = $entry->asArray();
        $entryArray['created_with'] = 'toggl-time-entry-pusher';
        $options = [
            'auth' => [$this->apiToken, 'api_token'],
            'json' => ['time_entry' => $entryArray],
        ];

        try {
            $response = $this->client->request('POST', $uri, $options);
        } catch (GuzzleException $e) {
            $message = 'Error: ' . $e->getMessage() . PHP_EOL
                . '  ' . $entry->asString();
            $this->outputter->output($message);

            return false;
        }

        $code = $response->getStatusCode();
        if ($code !== 200) {
            $reason = $response->getReasonPhrase();
            $message = 'Error: ' . $code . ': ' . $reason . PHP_EOL
                . '  ' . $entry->asString();
            $this->outputter->output($message);

            return false;
        }

        $message = '✔ ︎' . $entry->asString();
        $this->outputter->output($message);

        return true;
    }
}
