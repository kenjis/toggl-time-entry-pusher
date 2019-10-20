<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use PHPUnit\Framework\TestCase;

class TimeEntryFactoryTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $pidMap = [
            'FOO' => 11111,
            'FOOOPS' => 11111,
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
        $entry = $factory->create(
            $date,
            $code,
            $start,
            $stop,
            $desc
        );
        $this->assertInstanceOf(TimeEntry::class, $entry);
    }
}
