<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Line;

class TimeEntryLine extends AbstractLine
{
    private $start;
    private $stop;
    private $code;
    private $desc;

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
