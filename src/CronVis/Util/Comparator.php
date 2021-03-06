<?php


namespace CronVis\Util;

interface Comparator
{
    /**
     * Returns a negative integer if $a comes before $b, 0 if they are considered equal, and a strictly positive integer if $a comes after $b
     *
     * @param   mixed $a
     * @param   mixed $b
     *
     * @return  int
     */
    function compare($a, $b);
}
