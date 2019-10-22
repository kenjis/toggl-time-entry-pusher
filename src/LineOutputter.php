<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

class LineOutputter
{
    public function output(string $line = '') : void
    {
        echo $line . PHP_EOL;
    }
}
