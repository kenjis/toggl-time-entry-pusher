<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Line;

class TimeEntryLine extends AbstractLine
{
    /**
     * @var string
     */
    private $start;

    /**
     * @var string
     */
    private $stop;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $desc;

    public function getStart() : string
    {
        return $this->start;
    }

    public function getStop() : string
    {
        return $this->stop;
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function getDesc() : string
    {
        return $this->desc;
    }

    public function setStart(string $start) : void
    {
        $this->start = $start;
    }

    public function setStop(string $stop) : void
    {
        $this->stop = $stop;
    }

    public function setCode(string $code) : void
    {
        $this->code = $code;
    }

    public function setDesc(string $desc) : void
    {
        $this->desc = $desc;
    }
}
