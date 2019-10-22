<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use PHPUnit\Framework\TestCase;

class LineOutputterTest extends TestCase
{
    public function testCanOutputLine() : void
    {
        $outputer = new LineOutputter();

        $line = 'You can see in your terminal.';
        $this->expectOutputString($line . PHP_EOL);

        $line = 'You can see in your terminal.';
        $outputer->output($line);
    }
}
