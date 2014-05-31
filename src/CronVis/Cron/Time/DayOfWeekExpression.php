<?php


namespace CronVis\Cron\Time;

use DateTime;

class DayOfWeekExpression extends BaseExpression
{
    use TextualRepresentation;
    protected static $_WEEKDAYS = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'day of week';
    }

    /** @return int */
    public function getMin()
    {
        return 1;
    }

    /** @return int */
    public function getMax()
    {
        return 7;
    }

    public function preProcessNumber($value)
    {
        if ($this->_isValidTextualRepresentation($value, self::$_WEEKDAYS)) {
            $value = $this->_getTextualRepresentationOffset($value, self::$_WEEKDAYS);
        }

        if ($value == 0) {
            $value = 7;
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
        return $dateTime->format('N');
    }

    /**
     * @param   int $increment
     *
     * @return  string
     */
    protected function _createModificationString($increment)
    {
        return sprintf('midnight +%d days', $increment);
    }
}
