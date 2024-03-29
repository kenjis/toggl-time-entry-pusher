<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher;

use Kenjis\ToggleTimeEntryPusher\Exception\LogicException;
use Kenjis\ToggleTimeEntryPusher\Exception\RuntimeException;
use Kenjis\ToggleTimeEntryPusher\Line\DateLine;
use Kenjis\ToggleTimeEntryPusher\Line\OtherLine;
use Kenjis\ToggleTimeEntryPusher\Line\TimeEntryLine;
use Kenjis\ToggleTimeEntryPusher\Parser\ParserInterface;
use Kenjis\ToggleTimeEntryPusher\TimeEntry\NoPidTimeEntry;
use Kenjis\ToggleTimeEntryPusher\TimeEntry\TimeEntryFactory;
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
     * @var LineOutputter
     */
    private $outputter;

    /**
     * @var string
     */
    private $updatedText;

    /**
     * @var string
     */
    private $mode;

    public function __construct(
        ParserInterface $parser,
        TimeEntryFactory $factory,
        TimeEntryPusher $pusher,
        LineOutputter $outputter
    ) {
        $this->parser = $parser;
        $this->factory = $factory;
        $this->pusher = $pusher;
        $this->outputter = $outputter;
    }

    public function process(string $text) : string
    {
        $lines = explode("\n", $text);

        // check input text
        $this->mode = 'check';
        $this->processLines($lines);

        // push to Toggl
        $this->mode = 'push';
        $this->processLines($lines);

        return trim($this->updatedText);
    }

    private function processLines(array $lines) : void
    {
        $this->updatedText = '';
        $date = null;

        foreach ($lines as $lineString) {
            $line = $this->parser->parse($lineString);

            if ($line instanceof DateLine) {
                // update date
                $date = $line->getDate();

                $this->updatedText .= $lineString . "\n";

                continue;
            }

            if ($line instanceof TimeEntryLine) {
                // create TimeEntry
                if ($date === null) {
                    throw new RuntimeException(
                        'Cannot get date: ' . $lineString
                    );
                }

                $entry = $this->factory->create(
                    $date,
                    $line->getCode(),
                    $line->getStart(),
                    $line->getStop(),
                    $line->getDesc(),
                    $line->getTag()
                );

                if ($this->mode === 'push') {
                    if ($entry instanceof NoPidTimeEntry) {
                        $message = 'Skip: ' . $entry->asString();
                        $this->outputter->output($message);

                        $this->updatedText .= $lineString . "︎\n";

                        continue;
                    }

                    // push to Toggl

                    // > Limits will and can change during time,
                    // > but a safe window will be 1 request per second.
                    // https://github.com/toggl/toggl_api_docs#the-api-format
                    sleep(1);

                    if ($this->pusher->push($entry)) {
                        $this->updatedText .= '✔ ' . $lineString . "\n";
                    } else {
                        $this->updatedText .= $lineString . "︎\n";
                    }
                } else {
                    $this->updatedText .= $lineString . "︎\n";
                }

                continue;
            }

            if ($line instanceof OtherLine) {
                $this->updatedText .= $lineString . "\n";

                continue;
            }

            throw new LogicException('Unknown class: ' . get_class($line));
        }
    }
}
