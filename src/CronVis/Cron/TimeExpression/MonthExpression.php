<?php


namespace CronVis\Cron\TimeExpression;


use DateTime;

class MonthExpression extends BaseExpression
{
    protected $_at;

    /**
     * @param string $input
     */
    public function __construct($input = self::ANY)
    {
        if (!$this->_verifyFormat($input)) {
            $this->throwInvalidExpression($input);
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
        return $input === self::ANY || ($input > 0 && $input <= 12);
    }
}
