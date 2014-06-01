<?php


namespace CronVis\Cron;

use DateTimeImmutable;

class CronEvent
{
    /** @var CronEntry */
    protected $_cronEntry;
    /** @var DateTimeImmutable */
    protected $_time;

    public function __construct(DateTimeImmutable $time, CronEntry $cronEntry)
    {
        $this->_time = $time;
        $this->_cronEntry = $cronEntry;
    }

    public function getNext()
    {
        return $this->_cronEntry->getNextEvent($this->_time);
    }

    /**
     * @param DateTimeImmutable $time
     *
     * @return bool
     */
    public function occursAfter(DateTimeImmutable $time)
    {
        return $this->_time > $time;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTime()
    {
        return $this->_time;
    }

    public function getCommand()
    {
        return $this->_cronEntry->getCommand();
    }
}
