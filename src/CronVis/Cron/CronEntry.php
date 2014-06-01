<?php


namespace CronVis\Cron;

use DateTime;
use DateTimeImmutable;

class CronEntry
{
    /** @var CronCommand */
    protected $_command;
    /** @var TimeExpression */
    protected $_timeExpression;

    /**
     * @param TimeExpression $timeExpression
     * @param CronCommand    $command
     */
    public function __construct(TimeExpression $timeExpression, CronCommand $command)
    {
        $this->_command = $command;
        $this->_timeExpression = $timeExpression;
    }

    public function getFirstEvent(DateTimeImmutable $time)
    {
        $newTime = $this->_timeExpression->findMatch($time);
        return new CronEvent($newTime, $this);
    }

    /**
     * @param DateTimeImmutable $time
     *
     * @return CronEvent
     */
    public function getNextEvent(DateTimeImmutable $time)
    {
        $newTime = $time->add(new \DateInterval('PT1M'));
        return $this->getFirstEvent($newTime);
    }

    /**
     * @return CronCommand
     */
    public function getCommand()
    {
        return $this->_command;
    }
}
