<?php


namespace CronVis\Cron\Time\Common;

use CronVis\Cron\Time\BaseExpression;

class Factory
{
    /**
     * @param   BaseExpression $expression
     * @param   int            $input
     *
     * @return  Expression
     * @throws  \InvalidArgumentException
     */
    public static function createExpressionFor(BaseExpression $expression, $input)
    {
        if ($input === BaseExpression::ANY) {
            return new AnyExpression();
        }

        if (strpos($input, '/') !== false || strpos($input, '-') !== false) {
            return new RangeExpression($expression, $input);
        }

        return new ListExpression($expression, $input);
    }
}
