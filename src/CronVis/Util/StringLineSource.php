<?php


namespace CronVis\Util;

class StringLineSource implements LineSource
{
    /** @var string[] */
    private $_input;

    function __construct($input)
    {
        $this->_input = explode('\n', $input);
    }

    /** @return \Generator<string> */
    function getLines()
    {
        foreach ($this->_input as $line) {
            yield $line;
        }
    }
}
