<?php


namespace CronVis\Util;
use CronVis\Cron\CronEvent;
use InvalidArgumentException;

/**
 * Class SortedEventList
 * @package CronVis
 * @method add(CronEvent $event)
 * @method CronEvent shift()
 */
class SortedEventList extends SortedList
{
    /**
     * Returns a negative integer if $a comes before $b, 0 if they are considered equal, and a strictly positive integer if $a comes after $b
     *
     * @param CronEvent $a
     * @param CronEvent $b
     * @throws InvalidArgumentException
     * @return int
     */
    protected function _compare($a, $b)
    {
        if (! ($a instanceof CronEvent && $b instanceof CronEvent)) {
            throw new InvalidArgumentException("Trying to compare a non-event");
        }

        return $a->getTime()->getTimestamp() - $b->getTime()->getTimestamp();
    }
}