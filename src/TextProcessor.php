<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;
use Kenjis\ToggleTimeEntryPusher\Line\DateLine;
use Kenjis\ToggleTimeEntryPusher\Line\TimeEntryLine;
use Kenjis\ToggleTimeEntryPusher\Parser\ParserInterface;
use Kenjis\ToggleTimeEntryPusher\Toggl\TimeEntryPusher;

class TextProcessor
{
    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var TimeEntryFactory
     */
    private $factory;

    /**
     * @var TimeEntryPusher
     */
    private $pusher;

    /**
     * @var string
     */
    private $updatedText;

    public function __construct(
        ParserInterface $parser,
        TimeEntryFactory $factory,
        TimeEntryPusher $pusher
    ) {
        $this->parser = $parser;
        $this->factory = $factory;
        $this->pusher = $pusher;
    }

    public function process(string $text) : string
    {
        $lines = explode("\n", $text);

        // check input text
        $this->processLines($lines);

        // push to Toggl
        $this->processLines($lines, true);

        return $this->updatedText;
    }

    private function processLines(array $lines, bool $push = false) : void
    {
        $this->updatedText = '';
        $date = null;

        foreach ($lines as $lineString) {
            $line = $this->parser->parse($lineString);

            if ($line instanceof DateLine) {
                // update date
                $date = $line->getDate();

                $this->updatedText .= $lineString . "\n";
            } elseif ($line instanceof TimeEntryLine) {
                // create TimeEntry
                if ($date === null) {
                    throw new RuntimeException('Cannot get date');
                }

                $entry = $this->factory->create(
                    $date,
                    $line->getCode(),
                    $line->getStart(),
                    $line->getStop(),
                    $line->getDesc()
                );

                if ($push && $entry !== null) {
                    // push to Toggl
                    // @TODO catch exceptions
                    $this->pusher->push($entry);
                    $this->updatedText .= '✔ ︎' . $lineString . "\n";
                } else {
                    $this->updatedText .= $lineString . "︎\n";
                }
            } else {
                $this->updatedText .= $lineString . "\n";
            }
        }
    }
}
