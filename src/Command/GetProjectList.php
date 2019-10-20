<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Command;

use Kenjis\ToggleTimeEntryPusher\Toggl\ProjectFetcher;

class GetProjectList
{
    /**
     * @var ProjectFetcher
     */
    private $fetcher;

    public function __construct(ProjectFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function run()
    {
        $response = $this->fetcher->fetch();
        $jsonString = $response->getBody()->getContents();
        $list = json_decode($jsonString, true);

        foreach ($list as $project) {
            foreach ($project as $key => $val) {
                printf('%14s: %s' . PHP_EOL, $key, $val);
            }
            echo PHP_EOL;
        }
    }
}
