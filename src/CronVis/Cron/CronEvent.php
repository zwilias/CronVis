<?php


namespace CronVis\Cron;
use DateTime;


class CronEvent
{
    /** @var CronEntry */
    protected $_cronEntry;
    /** @var DateTime */
    protected $_time;

    public function __construct(DateTime $time, CronEntry $cronEntry)
    {
        $this->_time = $time;
        $this->_cronEntry = $cronEntry;
    }

    public function getNext()
    {
        return $this->_cronEntry->getNextEvent($this->_time);
    }

    /**
     * @param DateTime $time
     * @return bool
     */
    public function occursAfter(DateTime $time)
    {
        return $this->_time > $time;
    }

    /**
     * @return DateTime
     */
    public function getTime()
    {
        return $this->_time;
    }
}