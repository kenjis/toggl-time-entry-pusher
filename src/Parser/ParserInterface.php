<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Parser;

use Kenjis\ToggleTimeEntryPusher\Line\AbstractLine;

interface ParserInterface
{
    public function parse(string $lineString) : AbstractLine;
}
