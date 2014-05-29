<?php


namespace CronVis\Parser;


interface Matchable
{
    /**
     * @param string $input
     * @return string|false
     */
    function matches($input);
}
