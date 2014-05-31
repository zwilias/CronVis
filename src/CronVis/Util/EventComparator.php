<?php

namespace CronVis\Util;

use CronVis\Cron\CronEvent;
use InvalidArgumentException;

class EventComparator implements Comparator
{
    /**
     * @param   CronEvent $a
     * @param   CronEvent $b
     *
     * @return  int
     */
    public function compare($a, $b)
    {
        if (!($a instanceof CronEvent && $b instanceof CronEvent)) {
            throw new InvalidArgumentException("Trying to compare a non-event");
        }

        return $a->getTime()->getTimestamp() - $b->getTime()->getTimestamp();
    }
}
