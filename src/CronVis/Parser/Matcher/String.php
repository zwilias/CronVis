<?php

namespace CronVis\Parser\Matcher;

use CronVis\Parser\Matchable;

class String implements Matchable
{
    private $_string;

    public function __construct($string)
    {
        $this->_string = $string;
    }

    /**
     * @param string $input
     *
     * @return string|false
     */
    function matches($input)
    {
        if (strpos($input, $this->_string) === 0) {
            return $this->_string;
        }

        return false;
    }
}
