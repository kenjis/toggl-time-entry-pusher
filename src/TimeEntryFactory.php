<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;

class TimeEntryFactory
{
    /**
     * @var array [Project Code => Toggl PID]
     */
    private $pidMap;

    /**
     * @var array [Project Code Suffix => Toggl Tag Name]
     */
    private $tagMap;

    public function __construct(array $pidMap, array $tagMap = [])
    {
        $this->pidMap = $pidMap;
        $this->tagMap = $tagMap;
    }

    public function create(
        string $date,
        string $code,
        string $start,
        string $stop,
        string $desc
    ) : ?TimeEntry {
        if (! isset($this->pidMap[$code])) {
            return null;
//            throw new RuntimeException('Cannot get pid: ' . $code);
        }
        $pid = $this->pidMap[$code];

        $entry = new TimeEntry(
            $date . ' ' . $start,
            $date . ' ' . $stop
        );

        $entry->setTogglPid($pid);
        $entry->setDescription($desc);

        // Add tag for OPS
        if (substr($code, -3) === 'OPS') {
            if (! isset($this->tagMap['OPS'])) {
                throw new RuntimeException('Cannot get tag name: ' . $code);
            }

            $entry->addTag($this->tagMap['OPS']);
        }

        return $entry;
    }
}
