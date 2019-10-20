<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Toggl;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ProjectFetcher
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Workspace ID
     *
     * @var int
     */
    private $wid;

    /**
     * @var string
     */
    private $apiToken;

    public function __construct(Client $client, int $wid, string $apiToken)
    {
        $this->client = $client;
        $this->wid = $wid;
        $this->apiToken = $apiToken;
    }

    public function fetch() : ResponseInterface
    {
        // https://github.com/toggl/toggl_api_docs/blob/master/chapters/workspaces.md#get-workspace-projects
        $uri = 'workspaces/' . $this->wid . '/projects';
        $options = [
            'auth' => [$this->apiToken, 'api_token'],
        ];

        return $this->client->request('GET', $uri, $options);
    }

    public function fetchAsArray() : array
    {
        $response = $this->fetch();
        $jsonString = $response->getBody()->getContents();

        return json_decode($jsonString, true);
    }
}
