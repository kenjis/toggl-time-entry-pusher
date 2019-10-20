<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Line;

class DateLine extends AbstractLine
{
    /**
     * @var string
     */
    private $date;

    public function setDate(string $date) : void
    {
        $this->date = $date;
    }
}
