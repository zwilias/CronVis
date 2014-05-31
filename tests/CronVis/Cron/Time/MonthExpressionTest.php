<?php


namespace CronVis\Cron\Time;


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


    /**
     * @param $inputA
     * @param $inputB
     * @dataProvider provideEquivalentExpressions
     */
    public function testEquivalentExpression($inputA, $inputB)
    {
        $expressionA = new MonthExpression($inputA);
        $expressionB = new MonthExpression($inputB);
        $time = new \DateTime('2014-05-27 22:47:00');


        $oneMonth = new \DateInterval('P1M');
        for ($i = 0; $i < 12; $i++) {
            $this->assertEquals(
                $expressionA->matches($time),
                $expressionB->matches($time)
            );
            $time->add($oneMonth);
        }
    }

    /**
     * @return array
     */
    public function provideEquivalentExpressions()
    {
        return [
            ['jan', 1],
            ['feb', 2],
            ['mar', 3],
            ['apr', 4],
            ['may', 5],
            ['jun', 6],
            ['jul', 7],
            ['aug', 8],
            ['sep', 9],
            ['oct', 10],
            ['nov', 11],
            ['dec', 12],
            ['jan', 'JANUARY'],
            ['feb', 'FEBRUARY'],
            ['mar', 'MARCH'],
            ['apr', 'APRIL'],
            ['may', 'MAY'],
            ['jun', 'JUNE'],
            ['jul', 'JULY'],
            ['aug', 'AUGUST'],
            ['sep', 'SEPTEMBER'],
            ['oct', 'OCTOBER'],
            ['nov', 'NOVEMBER'],
            ['dec', 'DECEMBER'],
        ];
    }
}
