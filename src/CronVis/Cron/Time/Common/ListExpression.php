<?php


namespace CronVis\Cron\Time\Common;


use CronVis\Cron\Time\BaseExpression;

class ListExpression implements Expression
{
    protected $_values = [];

    /**
     * @param BaseExpression    $baseExpression
     * @param string|string[]   $values
     * @throws  \InvalidArgumentException
     */
    public function __construct(BaseExpression $baseExpression, $values)
    {
        if (!is_array($values)) {
            $values = explode(',', $values);
        }

        foreach ($values as $value) {
            $processed = $baseExpression->preProcessNumber($value);

            if (
                !(int)$processed === $processed
                || $processed < $baseExpression->getMin()
                || $processed > $baseExpression->getMax()
            ) {
                throw new \InvalidArgumentException(
                    sprintf("Invalid value '%s' supplied for %s specifier", $value, $baseExpression->getDescription())
                );
            }

            $this->_values[] = $processed;
        }
    }

    /**
     * @param   int $value
     *
     * @return  boolean
     */
    public function matches($value)
    {
        return in_array($value, $this->_values);
    }

    /**
     * @param   int $jumpFrom
     *
     * @return  int
     */
    public function getIncrement($jumpFrom)
    {
        $diffs = array_map(
            function($jumpTo) use ($jumpFrom) {
                return min(1, $jumpTo - $jumpFrom);
            }, $this->_values
        );

        return min($diffs);
    }
}
