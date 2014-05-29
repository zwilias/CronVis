<?php


namespace CronVis\Cron\TimeExpression;


class DayOfWeekExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testMatchesAny()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $dayOfWeekExpression = new DayOfWeekExpression(BaseExpression::ANY);


        $oneDay = new \DateInterval('P1D');
        for ($i = 0; $i < 7; $i++) {
            $this->assertTrue($dayOfWeekExpression->matches($time));
            $time->add($oneDay);
        }
    }

    public function testMatchesAt()
    {
        $time = new \DateTime('2014-05-27 22:47:00');
        $dayOfWeekExpression = new DayOfWeekExpression(1);


        $oneDay = new \DateInterval('P1D');
        for ($i = 0; $i < 6; $i++) {
            $this->assertFalse($dayOfWeekExpression->matches($time));
            $time->add($oneDay);
        }


        $this->assertTrue($dayOfWeekExpression->matches($time));
    }

    public function testMatchesAt_ZeroAnd7AreBothSunday()
    {
        $time = new \DateTime('2014-06-01 22:47:00');
        $sunday0Expression = new DayOfWeekExpression(0);
        $sunday7Expression = new DayOfWeekExpression(7);


        $this->assertTrue($sunday0Expression->matches($time));
        $this->assertTrue($sunday7Expression->matches($time));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_DOWSmallerThanZero()
    {
        new DayOfWeekExpression(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException_DOWOver7()
    {
        new DayOfWeekExpression(8);
    }

    /**
     * @param $inputA
     * @param $inputB
     * @dataProvider provideEquivalentExpressions
     */
    public function testEquivalentExpression($inputA, $inputB)
    {
        $expressionA = new DayOfWeekExpression($inputA);
        $expressionB = new DayOfWeekExpression($inputB);
        $time = new \DateTime('2014-05-27 22:47:00');


        $oneDay = new \DateInterval('P1D');
        for ($i = 0; $i < 7; $i++) {
            $this->assertEquals(
                $expressionA->matches($time),
                $expressionB->matches($time)
            );
            $time->add($oneDay);
        }
    }

    /**
     * @return array
     */
    public function provideEquivalentExpressions()
    {
        return [
            ['mon', 1],
            ['tue', 2],
            ['wed', 3],
            ['thu', 4],
            ['fri', 5],
            ['sat', 6],
            ['sun', 7],
            ['mon', 'MONDAY'],
            ['tue', 'TUESDAY'],
            ['wed', 'WEDNESDAY'],
            ['thu', 'THURSDAY'],
            ['fri', 'FRIDAY'],
            ['sat', 'SATURDAY'],
            ['sun', 'SUNDAY'],
        ];
    }
}
