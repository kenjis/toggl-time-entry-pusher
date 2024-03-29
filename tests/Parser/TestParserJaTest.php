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
        $this->assertSame('FOO', $line->getCode());
    }

    public function testCanParseTimeEntryWithTag() : void
    {
        $parser = new TextParserJa();

        $text = '09:30-10:00[30] FOO_OPS #1110 クラス設計';
        $line = $parser->parse($text);

        $this->assertInstanceOf(TimeEntryLine::class, $line);
        $this->assertSame('FOO', $line->getCode());
        $this->assertSame('OPS', $line->getTag());
    }

    public function testCanParseOtherLine() : void
    {
        $parser = new TextParserJa();

        $text = '■本日の報告';
        $line = $parser->parse($text);

        $this->assertInstanceOf(OtherLine::class, $line);
    }
}
