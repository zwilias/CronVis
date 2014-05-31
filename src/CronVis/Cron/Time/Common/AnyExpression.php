<?php


namespace CronVis\Cron\Time\Common;


class AnyExpression implements Expression
{
    /**
     * @param   int $value
     *
     * @return  boolean
     */
    public function matches($value)
    {
        return true;
    }

    /**
     * @param   int $value
     *
     * @return  int
     */
    public function getIncrement($value)
    {
        return 0;
    }
}
