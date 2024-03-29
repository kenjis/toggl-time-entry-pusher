<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\TimeEntry;

use DateTimeImmutable;

class TimeEntry
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $togglPid;

    /**
     * @var DateTimeImmutable
     */
    private $start;

    /**
     * @var DateTimeImmutable
     */
    private $stop;

    /**
     * Seconds
     *
     * @var int
     */
    private $duration;

    /**
     * @var string[]
     */
    private $togglTags;

    public function __construct(string $code, string $start, string $stop)
    {
        $this->code = $code;
        $this->start = new DateTimeImmutable($start);
        $this->stop = new DateTimeImmutable($stop);

        $this->duration =
            (int) $this->stop->format('U') - (int) $this->start->format('U');
    }

    public function setDescription(string $desc) : void
    {
        $this->description = $desc;
    }

    public function asArray() : array
    {
        return [
            'pid' => $this->togglPid,
            'tags' => $this->togglTags,
            'description' => $this->description,
            'start' => $this->start->format('c'),
            'stop' => $this->stop->format('c'),
            'duration' => $this->duration,
        ];
    }

    public function addTag(string $tag) : void
    {
        $this->togglTags[] = $tag;
    }

    public function setTogglPid(int $pid) : void
    {
        $this->togglPid = $pid;
    }

    public function asString()
    {
        return $this->start->format('Y-m-d')
            . ' ' . $this->start->format('H:i')
            . '-' . $this->stop->format('H:i')
            . '[' . (int) ($this->duration / 60) . '] '
            . $this->code
            . ($this->togglTags === null ? '' : $this->togglTags[0])
            . ' ' . $this->description;
    }
}
