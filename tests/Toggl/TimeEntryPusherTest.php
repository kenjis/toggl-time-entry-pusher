<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Toggl;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Kenjis\ToggleTimeEntryPusher\FakeOutputter;
use Kenjis\ToggleTimeEntryPusher\TimeEntry\TimeEntryFactory;
use PHPUnit\Framework\TestCase;

class TimeEntryPusherTest extends TestCase
{
    public function testCanPushEntry() : void
    {
        $client = $this->createMock(Client::class);
        $client->method('request')
            ->willReturn(new Response());
        $outputter = new FakeOutputter();
        $pusher = new TimeEntryPusher(
            $client,
            'dummy_api_key',
            $outputter
        );

        $pidMap = [
            'FOO' => 11111,
        ];
        $factory = new TimeEntryFactory($pidMap);
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

        $this->assertTrue($pusher->push($entry));
    }
}
