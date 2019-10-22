<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use PHPUnit\Framework\TestCase;

class TimeEntryTest extends TestCase
{
    /**
     * @var timeEntry
     */
    protected $timeEntry;

    protected function setUp() : void
    {
        date_default_timezone_set('Asia/Tokyo');

        $this->timeEntry = new TimeEntry(
            'FOO',
            '2019/10/20 14:00',
            '2019/10/20 15:00'
        );
    }

    public function testIsInstanceOfTimeEntry() : void
    {
        $actual = $this->timeEntry;
        $this->assertInstanceOf(TimeEntry::class, $actual);
    }

    public function testCanSetDescription() : void
    {
        $actual = $this->timeEntry;
        $desc = 'What you did';
        $actual->setDescription($desc);
        $this->assertSame($desc, $actual->asArray()['description']);
    }

    public function testCanAddTags() : void
    {
        $actual = $this->timeEntry;
        $tag = 'operation';
        $actual->addTag($tag);
        $this->assertSame([$tag], $actual->asArray()['tags']);
    }

    public function testCanSetTogglPid() : void
    {
        $actual = $this->timeEntry;
        $pid = 12345;
        $actual->setTogglPid($pid);
        $this->assertSame($pid, $actual->asArray()['pid']);
    }

    public function testCanGetDuration() : void
    {
        $actual = $this->timeEntry;
        $this->assertSame(3600, $actual->asArray()['duration']);
    }

    public function testCanGetAsArray() : void
    {
        $actual = $this->timeEntry;

        $desc = 'What you did';
        $actual->setDescription($desc);
        $tag = 'operation';
        $actual->addTag($tag);
        $pid = 12345;
        $actual->setTogglPid($pid);

        $this->assertSame(
            [
                'pid' => $pid,
                'tags' => [$tag],
                'description' => $desc,
                'start' => '2019-10-20T14:00:00+09:00',
                'stop' => '2019-10-20T15:00:00+09:00',
                'duration' => 3600,
            ],
            $actual->asArray()
        );
    }

    public function testCanGetAsString() : void
    {
        $actual = $this->timeEntry;
        $desc = 'What you did';
        $actual->setDescription($desc);
        $pid = 12345;
        $actual->setTogglPid($pid);

        $this->assertSame(
            '2019-10-20 14:00-15:00 FOO What you did',
            $actual->asString()
        );
    }
}
