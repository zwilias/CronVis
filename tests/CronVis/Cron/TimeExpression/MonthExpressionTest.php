<?php


namespace CronVis\Cron\TimeExpression;


class MonthExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testMatchesAny()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $monthExpression = new MonthExpression(BaseExpression::ANY);


        $oneMonth = new \DateInterval('P1M');
        for ($i = 0; $i < 12; $i++) {
            $this->assertTrue($monthExpression->matches($time));
            $time->add($oneMonth);
        }
    }

    public function testMatchesAt()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $monthExpression = new MonthExpression(4);


        $oneMonth = new \DateInterval('P1M');
        for ($i = 0; $i < 11; $i++) {
            $this->assertFalse($monthExpression->matches($time));
            $time->add($oneMonth);
        }


        $this->assertTrue($monthExpression->matches($time));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_MonthSmallerThanOne()
    {
        new MonthExpression(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_MonthOver12()
    {
        new MonthExpression(13);
    }
}
