<?php


namespace CronVis\Cron\TimeExpression;

use DateTime;

class MonthExpression extends BaseExpression
{
    use TextualCheckTrait;

    /** @var string */
    protected $_at;
    /** @var string[] */
    protected static $_MONTHS = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

    /**
     * @param string $input
     */
    protected function _assignInput($input)
    {
        if ($this->_isValidTextual($input, self::$_MONTHS)) {
            $input = $this->_getTextualOffset($input, self::$_MONTHS);
        }

        $this->_at = $input;
    }

    /**
     * @return string
     */
    protected function _getDescription()
    {
        return 'month';
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  bool
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_at === self::ANY || (int)$dateTime->format('m') == $this->_at;
    }

    /**
     * @param   string $input
     *
     * @return  boolean
     */
    protected function _verifyFormat($input)
    {
        return $this->_verifyAtFormat($input, 1, 12)
            || $this->_isValidTextual($input, self::$_MONTHS);
    }
}
