<?php

namespace CronVis\Cron\Time;

use DateTime;

class MinuteExpression extends BaseExpression
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'minute';
    }

    /** @return int */
    public function getMin()
    {
        return 0;
    }

    /** @return int */
    public function getMax()
    {
        return 59;
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  int
     */
    protected function _extractFromDateTime(DateTime $dateTime)
    {
        return (int)$dateTime->format('i');
    }

    /**
     * @param   int $increment
     *
     * @return  \DateInterval
     */
    protected function _wrapIntoInterval($increment)
    {
        return new \DateInterval(sprintf('PT%dM', $increment));
    }
}
