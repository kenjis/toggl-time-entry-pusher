<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Parser;

use Kenjis\ToggleTimeEntryPusher\Line\AbstractLine;
use Kenjis\ToggleTimeEntryPusher\Line\DateLine;
use Kenjis\ToggleTimeEntryPusher\Line\OtherLine;
use Kenjis\ToggleTimeEntryPusher\Line\TimeEntryLine;

class TextParserJa implements ParserInterface
{
    public function parse(string $lineString) : AbstractLine
    {
        $pattern = '!\A([0-9]{4}/[0-9]{2}/[0-9]{2})!u';
        if (preg_match($pattern, $lineString, $matches)) {
            $line = new DateLine($lineString);
            $line->setDate($matches[1]);

            return $line;
        }

        $pattern = '!\A([0-9]{2}:[0-9]{2})-([0-9]{2}:[0-9]{2})\[[0-9]+\] ([A-Z_]+) (.*)!u';
        if (preg_match($pattern, $lineString, $matches)) {
            $line = new TimeEntryLine($lineString);
            $line->setStart($matches[1]);
            $line->setStop($matches[2]);
            $line->setCode($matches[3]);
            $line->setDesc($matches[4]);

            return $line;
        }

        return new OtherLine($lineString);
    }
}
