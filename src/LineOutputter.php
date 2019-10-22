<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

class LineOutputter
{
    public function output(string $line)
    {
        echo $line . PHP_EOL;
    }
}
