<?php

namespace CronVis\Cron;

use DateTime, DateInterval;
use CronVis\Util\SortedEventList;

define('TIME_FORMAT', 'Y-m-d H:i:s');

class CronTab
{
    /** @var DateTime */
    protected $_startTime;
    /** @var DateTime */
    protected $_endTime;
    /** @var SortedEventList */
    protected $_eventList;
    /** @var CronEntry[] */
    protected $_entries = [];

    public function __construct()
    {
        $this->_startTime = new DateTime('now');
        $this->_endTime = (new DateTime('now'))->add(new DateInterval('P1W'));
        $this->_eventList = new SortedEventList();
    }

    public function addCronEntry(CronEntry $entry)
    {
        $this->_entries[] = $entry;
        $this->_eventList->add($entry->getNextEvent($this->_startTime));
    }

    /**
     * @return CronEvent[]
     */
    public function getEvents()
    {
        while (count($this->_eventList) > 0) {
            $event = $this->_eventList->shift()->getNext();

            if ($event->occursAfter($this->_endTime)) {
                continue;
            }

            $this->_eventList->add($event);
            yield $event;
        }
    }

    /**
     * @return CronEntry[]
     */
    public function getEntries()
    {
        foreach ($this->_entries as $entry) {
            yield $entry;
        }
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getStartTime($format = TIME_FORMAT)
    {
        return $this->_startTime->format($format);
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getEndTime($format = TIME_FORMAT)
    {
        return $this->_endTime->format($format);
    }
}
