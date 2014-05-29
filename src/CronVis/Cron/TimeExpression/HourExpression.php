<?php

namespace CronVis\Cron\TimeExpression;


use DateTime;

class HourExpression extends BaseExpression
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
        return $this->_at == self::ANY || (int)$dateTime->format('H') == $this->_at;
    }

    protected function _verifyFormat($at)
    {
        return $at === self::ANY || ($at >= 0 && $at < 24);
    }

    /**
     * @return string
     */
    protected function _getDescription()
    {
        return 'hour';
    }
}
