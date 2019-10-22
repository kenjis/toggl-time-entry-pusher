<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Command;

use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;
use Kenjis\ToggleTimeEntryPusher\TextProcessor;

class PushTimeEntries
{
    /**
     * @var TextProcessor
     */
    private $processor;

    public function __construct(TextProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function run(string $file) : void
    {
        if (! is_readable($file)) {
            throw new RuntimeException('Cannot read file: ' . $file);
        }

        $updatedText = $this->processor->process(file_get_contents($file));
        $updatedText = trim($updatedText) . "\n";
        file_put_contents($file, $updatedText, LOCK_EX);
    }
}
