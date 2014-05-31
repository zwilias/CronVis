<?php

namespace CronVis\Parser\Matcher;

use CronVis\Parser\Matchable;

class Regex implements Matchable
{
    /** @var string */
    private $_regex;

    /**
     * @param string $regex
     */
    public function __construct($regex)
    {
        $this->_regex = '/^(' . $regex . ')/';
    }

    /**
     * @param string $input
     *
     * @return false|string[]
     */
    public function matches($input)
    {
        if (preg_match($this->_regex, $input, $matches)) {
            return $matches[1];
        }

        return false;
    }
}
