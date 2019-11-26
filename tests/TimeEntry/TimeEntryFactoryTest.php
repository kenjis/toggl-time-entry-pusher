<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\TimeEntry;

use PHPUnit\Framework\TestCase;

class TimeEntryFactoryTest extends TestCase
{
    public function testCanCreateInstance() : void
    {
        $pidMap = [
            'FOO' => 11111,
        ];
        $tagMap = [
            'OPS' => '保守',
        ];
        $factory = new TimeEntryFactory($pidMap, $tagMap);

        $date = '2019/10/20';
        $code = 'FOO';
        $start = '10:00';
        $stop = '10:35';
        $desc = '#1111 クラス設計';
        $tag = 'OPS';
        $entry = $factory->create(
            $date,
            $code,
            $start,
            $stop,
            $desc,
            $tag
        );

        $this->assertInstanceOf(TimeEntry::class, $entry);
        $this->assertSame(['保守'], $entry->asArray()['tags']);
    }
}
