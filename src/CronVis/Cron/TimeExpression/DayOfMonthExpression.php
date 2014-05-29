<?php

namespace CronVis\Cron\TimeExpression;


use DateTime;

class DayOfMonthExpression extends BaseExpression
{
    /** @var string */
    protected $_at;

    /**
     * @param string $input
     */
    protected function _assignInput($input)
    {
        $this->_at = $input;
    }

    /**
     * @param DateTime $dateTime
     * @return bool
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_at === self::ANY || (int)$dateTime->format('j') == $this->_at;
    }

    protected function _verifyFormat($at)
    {
        return $at === self::ANY || ($at > 1 && $at <= 31);
    }

    /**
     * @return string
     */
    protected function _getDescription()
    {
        return 'day of month';
    }
}
