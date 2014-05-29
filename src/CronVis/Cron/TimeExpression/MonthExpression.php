<?php


namespace CronVis\Cron\TimeExpression;


use DateTime;

class MonthExpression extends BaseExpression
{
    protected $_at;

    /**
     * @param string $input
     */
    protected function _assignInput($input)
    {
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
     * @return  bool
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_at === self::ANY || (int)$dateTime->format('m') == $this->_at;
    }

    /**
     * @param   string $input
     * @return  boolean
     */
    protected function _verifyFormat($input)
    {
        return $this->_verifyAtFormat($input, 1, 12);
    }
}
