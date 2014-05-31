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

        return new ListExpression($expression, $input);
    }
}
