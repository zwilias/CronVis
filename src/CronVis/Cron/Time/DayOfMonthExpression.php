<?php

namespace CronVis\Cron\Time;

use DateTime;

class DayOfMonthExpression extends BaseExpression
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'day of month';
    }

    /** @return int */
    public function getMin()
    {
        return 1;
    }

    /** @return int */
    public function getMax()
    {
        return 31;
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  int
     */
    protected function _extractFromDateTime(DateTime $dateTime)
    {
        return $dateTime->format('j');
    }

    /**
     * @param   int $increment
     *
     * @return  \DateInterval
     */
    protected function _wrapIntoInterval($increment)
    {
        return new \DateInterval(sprintf('P%dD', $increment));
    }
}
