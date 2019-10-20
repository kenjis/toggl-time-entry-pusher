<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Parser;

use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;
use Kenjis\ToggleTimeEntryPusher\TimeEntry;

class TextParserJa
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

    /**
     * @return TimeEntry[]
     */
    public function parse(string $text) : array
    {
        $lines = explode("\n", $text);

        $date = null;
        $array = [];

        foreach ($lines as $line) {
            // Get date
            $pattern = '!\A([0-9]{4}/[0-9]{2}/[0-9]{2})!u';
            if (preg_match($pattern, $line, $matches)) {
                $date = $matches[1];

                continue;
            }

            // Get an entry
            $pattern = '!\A([0-9]{2}:[0-9]{2})-([0-9]{2}:[0-9]{2})\[[0-9]+\] ([A-Z]+) (.*)!u';
            if (preg_match($pattern, $line, $matches)) {
                $start = $matches[1];
                $stop = $matches[2];
                $code = $matches[3];
                $desc = $matches[4];

                if ($date === null) {
                    throw new RuntimeException('Cannot get date');
                }

                $entry = $this->createTimeEntry(
                    $date,
                    $code,
                    $start,
                    $stop,
                    $desc
                );

                if ($entry !== null) {
                    $array[] = $entry;
                }

                continue;
            }
        }

        return $array;
    }

    private function createTimeEntry(
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
