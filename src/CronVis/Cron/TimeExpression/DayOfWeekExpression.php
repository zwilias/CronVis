<?php


namespace CronVis\Cron\TimeExpression;


use DateTime;

class DayOfWeekExpression extends BaseExpression
{
    /** @var string */
    protected $_at;
    /** @var string[] */
    protected static $_WEEKDAYS = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    /**
     * @param string $input
     */
    protected function _assignInput($input)
    {
        if ($this->_isValidWeekDay($input)) {
            $input = array_search(substr(strtolower($input), 0, 3), self::$_WEEKDAYS) + 1;
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
        return $input === self::ANY
            || $this->_isValidWeekDay($input)
            || ($input >= 0 && $input <= 7);
    }

    /**
     * @param   string $input
     * @return  boolean
     */
    protected function _isValidWeekDay($input)
    {
        $input = strtolower($input);

        $mapFunction = function($weekDay) use ($input) {
            return strpos(strtolower($input), $weekDay) === 0;
        };

        $reduceFunction = function($carry, $input) {
            return $carry | $input;
        };

        return array_reduce(
            array_map($mapFunction, self::$_WEEKDAYS),
            $reduceFunction,
            false
        );
    }
}
