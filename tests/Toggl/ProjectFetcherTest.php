<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Toggl;

require __DIR__ . '/../../conf/Config.php';

use Config;
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
            Config::WID,
            Config::API_KEY
        );

        $response = $fetcher->fetch();
        $this->assertInstanceOf(Response::class, $response);
    }
}
