<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Toggl;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ProjectFetcherTest extends TestCase
{
    public function testCanFetchProject() : void
    {
        $client = $this->createMock(Client::class);
        $client->method('request')
            ->willReturn(new Response());

        $fetcher = new ProjectFetcher(
            $client,
            123456,
            'dummy_api_key'
        );

        $response = $fetcher->fetch();
        $this->assertInstanceOf(Response::class, $response);
    }
}
