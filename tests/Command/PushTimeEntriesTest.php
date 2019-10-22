<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Command;

use Kenjis\ToggleTimeEntryPusher\TextProcessor;
use PHPUnit\Framework\TestCase;

class PushTimeEntriesTest extends TestCase
{
    public function testCanUpdateTextFile() : void
    {
        $file = __DIR__ . '/../fixture/input-file.txt';
        file_put_contents($file, 'This is an input file.' . "\n", LOCK_EX);

        $processor = $this->createMock(TextProcessor::class);
        $updatedText = 'This is updated text.';
        $processor->method('process')
            ->willReturn($updatedText);
        $command = new PushTimeEntries($processor);

        $command->run($file);

        $this->assertSame($updatedText . "\n", file_get_contents($file));
    }
}
