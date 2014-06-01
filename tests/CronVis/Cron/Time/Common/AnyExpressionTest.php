<?php


namespace CronVis\Cron\Time\Common;


class AnyExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testIncrementAlwaysZero()
    {
        $expr = new AnyExpression();


        $increment = $expr->getIncrement(0);


        $this->assertEquals(0, $increment);
    }
}
