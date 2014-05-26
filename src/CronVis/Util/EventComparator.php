<?php
/**
 * Created by PhpStorm.
 * User: ilias
 * Date: 26/05/14
 * Time: 22:42
 */

namespace CronVis\Util;

use CronVis\Cron\CronEvent;
use InvalidArgumentException;


class EventComparator implements Comparator
{
    /**
     * @param   CronEvent $a
     * @param   CronEvent $b
     * @return  int
     */
    public function compare($a, $b)
    {
        if (! ($a instanceof CronEvent && $b instanceof CronEvent)) {
            throw new InvalidArgumentException("Trying to compare a non-event");
        }

        return $a->getTime()->getTimestamp() - $b->getTime()->getTimestamp();
    }
} 