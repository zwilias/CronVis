<?php

namespace CronVis\Cron\TimeExpression;


use DateTime;

class DayOfMonthExpression extends BaseExpression
{
    /** @var string */
    protected $_at;

    /**
     * @param string $at
     */
    public function __construct($at = self::ANY)
    {
        if (!$this->_verifyFormat($at)) {
            $this->throwInvalidExpression($at);
        }

        $this->_at = $at;
    }

    /**
     * @param DateTime $dateTime
     * @return bool
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_at == self::ANY || (int)$dateTime->format('j') == $this->_at;
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
