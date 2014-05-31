<?php


namespace CronVis\Util;

use CronVis\Cron\CronEvent;

/**
 * Class SortedEventList
 * @package CronVis
 * @method  add(CronEvent $event)
 * @method  CronEvent shift()
 */
class SortedEventList extends SortedList
{
    public function __construct()
    {
        parent::__construct(new EventComparator());
    }
}
