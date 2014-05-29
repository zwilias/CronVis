<?php


namespace CronVis\Cron\TimeExpression;


use DateTime;

class DayOfWeekExpression extends BaseExpression
{
    use TextualCheckTrait;

    /** @var string */
    protected $_at;
    /** @var string[] */
    protected static $_WEEKDAYS = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    /**
     * @param string $input
     */
    protected function _assignInput($input)
    {
        if ($this->_isValidTextual($input, self::$_WEEKDAYS)) {
            $input = $this->_getTextualOffset($input, self::$_WEEKDAYS);
        }

        if ($input !== self::ANY) {
            $input -= 1;
            $input %= 7;
            if ($input < 0) {
                $input += 7;
            }
            $input += 1;
        }

        $this->_at = $input;
    }

    /**
     * @return string
     */
    protected function _getDescription()
    {
        return 'day of week';
    }

    /**
     * @param   DateTime $dateTime
     * @return  bool
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_at === self::ANY || (int)$dateTime->format('N') == $this->_at;
    }

    /**
     * @param   string $input
     * @return  boolean
     */
    protected function _verifyFormat($input)
    {
        return $this->_isValidTextual($input, self::$_WEEKDAYS)
            || $this->_verifyAtFormat($input, 0, 7);
    }
}
