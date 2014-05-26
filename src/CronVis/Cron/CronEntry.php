<?php


namespace CronVis\Cron;
use DateTime;


class CronEntry
{
    /** @var CronCommand */
    protected $_command;

    /**
     * @param CronCommand $command
     */
    public function __construct(CronCommand $command)
    {
        $this->_command = $command;
    }

    /**
     * @param DateTime $time
     * @return CronEvent
     */
    public function getNextEvent(DateTime $time)
    {
        // TODO: implement. Need to figure out how to do this, first, though.
        return new CronEvent($time, $this);
    }

    /**
     * @return CronCommand
     */
    public function getCommand()
    {
        return $this->_command;
    }
}