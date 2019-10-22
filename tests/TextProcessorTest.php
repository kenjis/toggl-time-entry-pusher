<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use Kenjis\ToggleTimeEntryPusher\Parser\TextParserJa;
use Kenjis\ToggleTimeEntryPusher\TimeEntry\TimeEntryFactory;
use Kenjis\ToggleTimeEntryPusher\Toggl\TimeEntryPusher;
use PHPUnit\Framework\TestCase;

class TextProcessorTest extends TestCase
{
    /**
     * @var TextProcessor
     */
    private $processor;

    protected function setUp() : void
    {
        $parser = new TextParserJa();
        $factory = new TimeEntryFactory(
            ['FOO' => 12345]
        );
        $pusher = $this->createMock(TimeEntryPusher::class);
        $pusher->method('push')
            ->willReturn(true);
        $outputter = new FakeOutputter();
        $this->processor = new TextProcessor(
            $parser,
            $factory,
            $pusher,
            $outputter
        );
    }

    public function testWhenEmptyTextThenReturnEmptyText() : void
    {
        $text = '';
        $actual = $this->processor->process($text);

        $expected = '';
        $this->assertSame($expected, $actual);
    }

    public function testCanGetUpdatedText() : void
    {
        $text = <<<'EOL'
2019/10/22
10:00-10:11[11] FOO #1111 Design Model
10:11-10:30[19] FOO #1112 Implement Model
EOL;
        $actual = $this->processor->process($text);

        $expected = <<<'EOL'
2019/10/22
✔ 10:00-10:11[11] FOO #1111 Design Model
✔ 10:11-10:30[19] FOO #1112 Implement Model
EOL;
        $this->assertSame($expected, $actual);
    }
}
