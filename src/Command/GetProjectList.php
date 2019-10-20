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

    public function run() : void
    {
        $list = $this->fetcher->fetchAsArray();

        foreach ($list as $project) {
            foreach ($project as $key => $val) {
                printf('%14s: %s' . PHP_EOL, $key, $val);
            }
            echo PHP_EOL;
        }
    }
}
