<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Parser;

use Kenjis\ToggleTimeEntryPusher\Line\DateLine;
use Kenjis\ToggleTimeEntryPusher\Line\OtherLine;
use Kenjis\ToggleTimeEntryPusher\Line\TimeEntryLine;
use PHPUnit\Framework\TestCase;

class TestParserJaTest extends TestCase
{
    public function testCanParseDate() : void
    {
        $parser = new TextParserJa();

        $text = '2019/10/18（金）';
        $line = $parser->parse($text);

        $this->assertInstanceOf(DateLine::class, $line);
    }

    public function testCanParseTimeEntry() : void
    {
        $parser = new TextParserJa();

        $text = '09:30-10:00[30] FOO #1110 クラス設計';
        $line = $parser->parse($text);

        $this->assertInstanceOf(TimeEntryLine::class, $line);
    }

    public function testCanParseOtherLine() : void
    {
        $pidMap = [
            'FOO' => 11111,
            'FOO_OPS' => 11111,
        ];
        $tagMap = [
            '_OPS' => '保守',
        ];
        $parser = new TextParserJa($pidMap, $tagMap);

        $text = '■本日の報告';
        $line = $parser->parse($text);

        $this->assertInstanceOf(OtherLine::class, $line);
    }
}
