<?php


namespace CronVis\Cron\Time\Common;


use CronVis\Cron\Time\BaseExpression;

class RangeExpression extends ListExpression
{
    /**
     * @param   BaseExpression   $baseExpression
     * @param   string           $input
     * @throws  \InvalidArgumentException
     */
    public function __construct(BaseExpression $baseExpression, $input)
    {
        $value = $input;

        $increment = 1;
        if (strpos($value, '/') !== false) {
            $increment = (int)$this->_getIncrement($baseExpression, $value);
            $value = substr($value, 0, strpos($value, '/'));
        }

        list($rangeMin, $rangeMax) = $this->_getRange($baseExpression, $value);

        if ($rangeMin < $baseExpression->getMin()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Range can\'t start before \'%d\' in \'%s\' for %s specifier',
                    $baseExpression->getMin(), $input, $baseExpression->getDescription()
                )
            );
        }

        if ($rangeMax > $baseExpression->getMax()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Range can\'t end after \'%d\' in \'%s\' for %s specifier',
                    $baseExpression->getMax(), $input, $baseExpression->getDescription()
                )
            );
        }

        if ($increment > $rangeMax - $rangeMin) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Increment %d doesn\'t fit in range %d-%d for %s specifier',
                    $increment, $rangeMin, $rangeMax, $baseExpression->getDescription()
                )
            );
        }

        $values = [];
        for ($i = $rangeMin; $i <= $rangeMax; $i += $increment) {
            $values[] = $i;
        }

        parent::__construct($baseExpression, $values);
    }

    private function _getIncrement(BaseExpression $baseExpression, $value)
    {
        $parts = explode('/', $value);

        if (count($parts) !== 2 || !ctype_digit($parts[1])) {
            throw new \InvalidArgumentException(
                sprintf('Invalid range format \'%s\' for %s specifier', $value, $baseExpression->getDescription())
            );
        }

        return (int)$parts[1];
    }

    /**
     * @param BaseExpression $baseExpression
     * @param string         $value
     *
     * @return int[]
     */
    private function _getRange(BaseExpression $baseExpression, $value)
    {
        $rangeMin = $baseExpression->getMin();
        $rangeMax = $baseExpression->getMax();

        if ($value === BaseExpression::ANY) {
            return array($rangeMin, $rangeMax);
        }

        if (strpos($value, '-') == false) {
            throw new \InvalidArgumentException(
                sprintf('Invalid range format \'%s\' for %s specifier', $value, $baseExpression->getDescription())
            );
        }

        $parts = explode('-', $value);

        if (count($parts) !== 2) {
            throw new \InvalidArgumentException(
                sprintf('Invalid range format \'%s\' for %s specifier', $value, $baseExpression->getDescription())
            );
        }

        $rangeMin = $baseExpression->preProcessNumber($parts[0]);
        $rangeMax = $baseExpression->preProcessNumber($parts[1]);

        return array($rangeMin, $rangeMax);
    }
}
