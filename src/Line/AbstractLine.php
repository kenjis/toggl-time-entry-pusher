<?php

declare(strict_types=1);

namespace Kenjis\ToggleTimeEntryPusher\Line;

abstract class AbstractLine
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $updatedText;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}
