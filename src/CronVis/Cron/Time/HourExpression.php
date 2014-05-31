<?php

namespace CronVis\Cron\Time;

use DateTime;

class HourExpression extends BaseExpression
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'hour';
    }

    /** @return int */
    public function getMin()
    {
        return 0;
    }

    /** @return int */
    public function getMax()
    {
        return 23;
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  int
     */
    protected function _extractFromDateTime(DateTime $dateTime)
    {
        return $dateTime->format('G');
    }

    /**
     * @param   int $increment
     *
     * @return  \DateInterval
     */
    protected function _wrapIntoInterval($increment)
    {
        return new \DateInterval(sprintf('PT%dH', $increment));
    }
}
