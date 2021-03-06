<?php


namespace CronVis\Cron\Time;


class HourExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testMatchesAny()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $hourExpression = new HourExpression(MinuteExpression::ANY);


        $oneHour = new \DateInterval('PT1H');
        for ($i = 0; $i < 24; $i++) {
            $this->assertTrue($hourExpression->matches($time));
            $time->add($oneHour);
        }
    }

    public function testMatchesAt()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $hourExpression = new HourExpression(21);


        $oneHour = new \DateInterval('PT1H');
        for ($i = 0; $i < 23; $i++) {
            $this->assertFalse($hourExpression->matches($time));
            $time->add($oneHour);
        }

        $this->assertTrue($hourExpression->matches($time));
    }

    public function testMatchesList()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $hourExpression = new HourExpression('21,23');


        $oneHour = new \DateInterval('PT1H');
        for ($i = 0; $i < 23; $i++) {
            $this->assertEquals(in_array($time->format('G'), [21, 23]), $hourExpression->matches($time));
            $time->add($oneHour);
        }
    }

    public function testMatchesRange()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $hourExpression = new HourExpression('21-23');


        $oneHour = new \DateInterval('PT1H');
        for ($i = 0; $i < 23; $i++) {
            $this->assertEquals(in_array($time->format('G'), [21, 22, 23]), $hourExpression->matches($time));
            $time->add($oneHour);
        }
    }

    public function testMatchesRangeWithIncrement()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $hourExpression = new HourExpression('21-23/2');


        $oneHour = new \DateInterval('PT1H');
        for ($i = 0; $i < 23; $i++) {
            $this->assertEquals(in_array($time->format('G'), [21, 23]), $hourExpression->matches($time));
            $time->add($oneHour);
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_HourSmallerThanZero()
    {
        new HourExpression(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_HourOver23()
    {
        new HourExpression(24);
    }
}
