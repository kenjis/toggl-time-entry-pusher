<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

require __DIR__ . '/../conf/Config.php';

use Kenjis\ToggleTimeEntryPusher\Parser\TextParserJa;
use PHPUnit\Framework\TestCase;

class TextProcessorFactoryTest extends TestCase
{
    public function testCanCreateInstance() : void
    {
        $parser = new TextParserJa();
        $factory = new TextProcessorFactory($parser);
        $processor = $factory->create();

        $this->assertInstanceOf(TextProcessor::class, $processor);
    }
}
