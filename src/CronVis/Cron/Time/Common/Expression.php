<?php


namespace CronVis\Cron\Time\Common;


interface Expression
{
    /**
     * @param   int $value
     *
     * @return  boolean
     */
    public function matches($value);

    /**
     * @param   int $value
     *
     * @return  int
     */
    public function getIncrement($value);
}
