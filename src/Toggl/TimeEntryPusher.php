<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Toggl;

use GuzzleHttp\Client;
use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;
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

    public function __construct(Client $client, string $apiToken)
    {
        $this->client = $client;
        $this->apiToken = $apiToken;
    }

    public function push(TimeEntry $entry) : void
    {
        // https://github.com/toggl/toggl_api_docs/blob/master/chapters/time_entries.md
        $uri = 'time_entries';
        $options = [
            'auth' => [$this->apiToken, 'api_token'],
            'json' => $entry->asArray(),
        ];

        $response = $this->client->request('POST', $uri, $options);

        $code = $response->getStatusCode();
        if ($code !== 200) {
            $reason = $response->getReasonPhrase();

            throw new RuntimeException($code . ': ' . $reason);
        }
    }
}
