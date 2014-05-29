<?php

namespace CronVis\Cron\TimeExpression;
use DateTime;
use InvalidArgumentException;


class MinuteExpression extends BaseExpression
{
    /** @var string */
    protected $_at = self::ANY;

    /**
     * @param string $input
     */
    protected function _assignInput($input)
    {
        $this->_at = $input;
    }

    /**
     * @param   DateTime $dateTime
     * @return  bool
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_at == self::ANY || (int)$dateTime->format('i') == $this->_at;
    }

    /**
     * @param   string $at
     * @return  bool
     */
    protected function _verifyFormat($at)
    {
        return $at === self::ANY || ($at >= 0 && $at < 60);
    }

    protected function _getDescription()
    {
        return 'minute';
    }
}
