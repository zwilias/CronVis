<?php

namespace CronVis\Cron\TimeExpression;

use DateTime;
use InvalidArgumentException;


abstract class BaseExpression
{
    const ANY = '*';

    /**
     * @param string $input
     */
    public function __construct($input = self::ANY)
    {
        if (!$this->_verifyFormat($input)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid %s expression supplied: %s',
                $this->_getDescription(),
                $input
            ));
        }

        $this->_assignInput($input);
    }

    /**
     * @return string
     */
    protected abstract function _getDescription();

    /**
     * @param   DateTime $dateTime
     * @return  boolean
     */
    public abstract function matches(DateTime $dateTime);

    /**
     * @param   string $input
     * @return  boolean
     */
    protected abstract function _verifyFormat($input);

    /**
     * @param   string $input
     */
    protected abstract function _assignInput($input);
}
