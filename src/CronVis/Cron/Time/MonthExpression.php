<?php


namespace CronVis\Cron\Time;

use DateTime;

class MonthExpression extends BaseExpression
{
    use TextualRepresentation;
    protected static $_MONTHS = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'month';
    }

    /** @return int */
    public function getMin()
    {
        return 1;
    }

    /** @return int */
    public function getMax()
    {
        return 12;
    }

    /**
     * @param int $value
     *
     * @return int
     */
    public function preProcessNumber($value)
    {
        if ($this->_isValidTextualRepresentation($value, self::$_MONTHS)) {
            $value = $this->_getTextualRepresentationOffset($value, self::$_MONTHS);
        }

        return parent::preProcessNumber($value);
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  int
     */
    protected function _extractFromDateTime(DateTime $dateTime)
    {
        return $dateTime->format('n');
    }

    /**
     * @param   int $increment
     *
     * @return  \DateInterval
     */
    protected function _createModificationString($increment)
    {
        return sprintf('midnight first day of +%d months', $increment);
    }
}
