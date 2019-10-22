<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Command;

use Kenjis\ToggleTimeEntryPusher\Toggl\ProjectFetcher;
use PHPUnit\Framework\TestCase;

class GetProjectListTest extends TestCase
{
    public function testCanGetProjectListOutput() : void
    {
        $fetcher = $this->createMock(ProjectFetcher::class);

        $array = [
            [
                'id' => 111111111,
                'wid' => 555555,
                'cid' => 44444444,
                'name' => 'ProjectA',
                'billable' => false,
                'is_private' => false,
                'active' => true,
                'template' => false,
                'at' => '2019-10-17T04:59:42+00:00',
                'created_at' => '2019-10-17T04:59:42+00:00',
                'color' => '0',
                'auto_estimates' => false,
                'actual_hours' => 5,
                'hex_color' => '#06aaf5',
            ],
            [
                'id' => 122222222,
                'wid' => 555555,
                'cid' => 43603781,
                'name' => 'ProjectB',
                'billable' => false,
                'is_private' => false,
                'active' => true,
                'template' => false,
                'at' => '2019-01-22T03:43:46+00:00',
                'created_at' => '2019-01-22T03:43:46+00:00',
                'color' => '9',
                'auto_estimates' => false,
                'actual_hours' => 64,
                'hex_color' => '#a01aa5',
            ]
        ];
        $fetcher->method('fetchAsArray')
            ->willReturn($array);

        $expected = <<<'EOL'
            id: 111111111
           wid: 555555
           cid: 44444444
          name: ProjectA
      billable: 
    is_private: 
        active: 1
      template: 
            at: 2019-10-17T04:59:42+00:00
    created_at: 2019-10-17T04:59:42+00:00
         color: 0
auto_estimates: 
  actual_hours: 5
     hex_color: #06aaf5

            id: 122222222
           wid: 555555
           cid: 43603781
          name: ProjectB
      billable: 
    is_private: 
        active: 1
      template: 
            at: 2019-01-22T03:43:46+00:00
    created_at: 2019-01-22T03:43:46+00:00
         color: 9
auto_estimates: 
  actual_hours: 64
     hex_color: #a01aa5


EOL;
        $this->expectOutputString($expected);

        $command = new GetProjectList($fetcher);
        $command->run();
    }
}
