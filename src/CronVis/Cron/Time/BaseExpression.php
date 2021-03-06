<?php

namespace CronVis\Cron\Time;

use CronVis\Cron\Time\Common\AnyExpression;
use CronVis\Cron\Time\Common\Expression;
use CronVis\Cron\Time\Common\Factory;
use DateTime;
use InvalidArgumentException;

abstract class BaseExpression
{
    const ANY = '*';

    /** @var  Expression */
    private $_expression;

    /**
     * @param string $input
     */
    public function __construct($input = self::ANY)
    {
        $this->_expression = Factory::createExpressionFor($this, $input);
    }

    public function isAny()
    {
        return $this->_getExpression() instanceof AnyExpression;
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  boolean
     */
    public function matches(DateTime $dateTime)
    {
        return $this->_getExpression()->matches($this->_extractFromDateTime($dateTime));
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  string
     */
    public function getIncrement(DateTime $dateTime)
    {
        return $this->_createModificationString($this->_getExpression()->getIncrement($this->_extractFromDateTime($dateTime)));
    }

    /**
     * @param DateTime $dateTime
     *
     * @return int
     */
    public function getRawIncrement(DateTime $dateTime)
    {
        return $this->_getExpression()->getIncrement($this->_extractFromDateTime($dateTime));
    }

    /**
     * @param   int $value
     *
     * @return  int
     * @throws  InvalidArgumentException
     */
    public function preProcessNumber($value)
    {
        return (int)$value;
    }

    /**
     * @return string
     */
    abstract public function getDescription();

    /** @return int */
    abstract public function getMin();

    /** @return int */
    abstract public function getMax();

    /**
     * @return Expression
     */
    protected function _getExpression()
    {
        return $this->_expression;
    }

    /**
     * @param   DateTime $dateTime
     *
     * @return  int
     */
    protected abstract function _extractFromDateTime(DateTime $dateTime);

    /**
     * @param   int $increment
     *
     * @return  string
     */
    protected abstract function _createModificationString($increment);
}
