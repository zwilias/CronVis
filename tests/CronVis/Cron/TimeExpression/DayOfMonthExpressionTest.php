<?php

namespace CronVis\Cron\TimeExpression;


class DayOfMonthExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testMatchesAny()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $domExpression = new DayOfMonthExpression(BaseExpression::ANY);


        $oneDay = new \DateInterval('P1D');
        for ($i = 0; $i < 31; $i++) {
            $this->assertTrue($domExpression->matches($time));
            $time->add($oneDay);
        }
    }

    public function testMatchesAt()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $domExpression = new DayOfMonthExpression(26);


        $oneDay = new \DateInterval('P1D');
        for ($i = 0; $i < 30; $i++) {
            $this->assertFalse($domExpression->matches($time));
            $time->add($oneDay);
        }

        $this->assertTrue($domExpression->matches($time));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_DomSmallerThanOne()
    {
        new DayOfMonthExpression(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_DomOver31()
    {
        new DayOfMonthExpression(32);
    }
}
