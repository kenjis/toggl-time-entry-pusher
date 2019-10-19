<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use PHPUnit\Framework\TestCase;

class ToggleTimeEntryPusherTest extends TestCase
{
    /**
     * @var ToggleTimeEntryPusher
     */
    protected $toggleTimeEntryPusher;

    protected function setUp() : void
    {
        $this->toggleTimeEntryPusher = new ToggleTimeEntryPusher;
    }

    public function testIsInstanceOfToggleTimeEntryPusher() : void
    {
        $actual = $this->toggleTimeEntryPusher;
        $this->assertInstanceOf(ToggleTimeEntryPusher::class, $actual);
    }
}
