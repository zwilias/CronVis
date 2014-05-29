<?php


namespace CronVis\Cron\TimeExpression;


trait AtCheckTrait
{
    /**
     * @param   string  $input
     * @param   int     $lowerBound
     * @param   int     $upperBound
     * @return  boolean
     */
    protected function _verifyAtFormat($input, $lowerBound, $upperBound)
    {
        return $input === BaseExpression::ANY
            || $input >= $lowerBound && $input <= $upperBound;
    }
}
