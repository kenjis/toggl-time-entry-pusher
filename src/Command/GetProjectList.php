<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Command;

use Kenjis\ToggleTimeEntryPusher\LineOutputter;
use Kenjis\ToggleTimeEntryPusher\Toggl\ProjectFetcher;

class GetProjectList
{
    /**
     * @var ProjectFetcher
     */
    private $fetcher;

    /**
     * @var LineOutputter
     */
    private $outputter;

    public function __construct(ProjectFetcher $fetcher, LineOutputter $outputter)
    {
        $this->fetcher = $fetcher;
        $this->outputter = $outputter;
    }

    public function run() : void
    {
        $list = $this->fetcher->fetchAsArray();

        foreach ($list as $project) {
            foreach ($project as $key => $val) {
                $this->outputter->output(
                    sprintf('%14s: %s', $key, $val)
                );
            }
            $this->outputter->output();
        }
    }
}
