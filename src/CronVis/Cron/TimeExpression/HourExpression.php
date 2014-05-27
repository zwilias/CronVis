<?php
/**
 * Created by PhpStorm.
 * User: ilias
 * Date: 27/05/14
 * Time: 23:05
 */

namespace CronVis\Cron\TimeExpression;


use DateTime;

class HourExpression extends BaseExpression
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