<?php


namespace CronVis\Cron\Time;


class MinuteExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testMatchesAny()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $minuteExpression = new MinuteExpression(MinuteExpression::ANY);


        $oneMinute = new \DateInterval('PT1M');
        for ($i = 0; $i < 60; $i++) {
            $this->assertTrue($minuteExpression->matches($time));
            $time->add($oneMinute);
        }
    }

    public function testMatchesAt()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $minuteExpression = new MinuteExpression(46);


        $oneMinute = new \DateInterval('PT1M');
        for ($i = 0; $i < 59; $i++) {
            $this->assertFalse($minuteExpression->matches($time));
            $time->add($oneMinute);
        }

        $this->assertTrue($minuteExpression->matches($time));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_MinuteSmallerThanZero()
    {
        new MinuteExpression(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_MinuteOver59()
    {
        new MinuteExpression(60);
    }
}
