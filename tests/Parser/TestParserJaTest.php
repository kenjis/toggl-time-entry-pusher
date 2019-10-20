<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Parser;

use PHPUnit\Framework\TestCase;

class TestParserJaTest extends TestCase
{
    public function testCanParseAnEntry() : void
    {
        $pidMap = [
            'FOO' => 11111,
        ];
        $parser = new TextParserJa($pidMap);

        $text = '2019/10/18（金）
■本日の報告
09:30-10:00[30] FOO #1110 クラス設計
';
        $array = [];
        foreach ($parser->parse($text) as $entry) {
            $array[] = $entry;
        }

        $this->assertCount(1, $array);

        $expected = [
            'pid' => 11111,
            'tags' => null,
            'description' => '#1110 クラス設計',
            'start' => '2019-10-18T09:30:00+09:00',
            'stop' => '2019-10-18T10:00:00+09:00',
            'duration' => 1800,
        ];
        $this->assertSame($expected, $array[0]->asArray());
    }

    public function testCanParseTwoEntries() : void
    {
        $pidMap = [
            'FOO' => 11111,
            'BAR' => 22222,
        ];
        $parser = new TextParserJa($pidMap);

        $text = '2019/10/18（金）
■本日の報告
09:30-10:00[30] FOO #1110 クラス設計
10:00-10:30[30] BAR #1111 レビュー
';
        $array = $parser->parse($text);
        $test = [];
        foreach ($array as $entry) {
            $test[] = $entry->asArray();
        }

        $expected = [
            [
                'pid' => 11111,
                'tags' => null,
                'description' => '#1110 クラス設計',
                'start' => '2019-10-18T09:30:00+09:00',
                'stop' => '2019-10-18T10:00:00+09:00',
                'duration' => 1800,
            ],
            [
                'pid' => 22222,
                'tags' => null,
                'description' => '#1111 レビュー',
                'start' => '2019-10-18T10:00:00+09:00',
                'stop' => '2019-10-18T10:30:00+09:00',
                'duration' => 1800,
            ],
        ];
        $this->assertSame($expected, $test);
    }

    public function testCanParseAnEntryOfOperation() : void
    {
        $pidMap = [
            'FOO' => 11111,
            'FOOOPS' => 11111,
        ];
        $tagMap = [
            'OPS' => '保守',
        ];
        $parser = new TextParserJa($pidMap, $tagMap);

        $text = '2019/10/18（金）
■本日の報告
09:00-09:30[30] FOO #1111 クラス設計
09:30-10:00[30] FOOOPS ログ確認
';
        $array = $parser->parse($text);
        $test = [];
        foreach ($array as $entry) {
            $test[] = $entry->asArray();
        }

        $expected = [
            [
                'pid' => 11111,
                'tags' => null,
                'description' => '#1111 クラス設計',
                'start' => '2019-10-18T09:00:00+09:00',
                'stop' => '2019-10-18T09:30:00+09:00',
                'duration' => 1800,
            ],
            [
                'pid' => 11111,
                'tags' => ['保守'],
                'description' => 'ログ確認',
                'start' => '2019-10-18T09:30:00+09:00',
                'stop' => '2019-10-18T10:00:00+09:00',
                'duration' => 1800,
            ],
        ];
        $this->assertSame($expected, $test);
    }
}
