<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

class FakeOutputter extends LineOutputter
{
    public function output(string $line = '') : void
    {
    }
}
