<?php

namespace CronVis\Cron\TimeExpression;

use DateTime;
use InvalidArgumentException;


abstract class BaseExpression
{
    const ANY = '*';

    /**
     * @param string $expression
     */
    protected function throwInvalidExpression($expression)
    {
        throw new InvalidArgumentException(sprintf(
            'Invalid %s expression supplied: %s',
            $this->_getDescription(),
            $expression
        ));
    }

    /**
     * @return string
     */
    protected abstract function _getDescription();

    public abstract function matches(DateTime $dateTime);
}
