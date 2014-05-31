<?php


namespace CronVis\Cron\Time\Common;


class RangeExpressionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenRangeStartLowerThanMin_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn('1');
        $baseExpressionMock->shouldReceive('getMax')->andReturn('3');
        $baseExpressionMock->shouldReceive('getDescription');


        new RangeExpression($baseExpressionMock, '0-2');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenRangeEndHigherThanMax_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn('1');
        $baseExpressionMock->shouldReceive('getMax')->andReturn('3');
        $baseExpressionMock->shouldReceive('getDescription');


        new RangeExpression($baseExpressionMock, '2-4');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenRangeEndBeforeStart_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn('1');
        $baseExpressionMock->shouldReceive('getMax')->andReturn('5');
        $baseExpressionMock->shouldReceive('getDescription');


        new RangeExpression($baseExpressionMock, '4-2');
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenNonNumericIncrement_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn('1');
        $baseExpressionMock->shouldReceive('getMax')->andReturn('5');
        $baseExpressionMock->shouldReceive('getDescription');


        new RangeExpression($baseExpressionMock, '*/bla');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenNoRange_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn('1');
        $baseExpressionMock->shouldReceive('getMax')->andReturn('5');
        $baseExpressionMock->shouldReceive('getDescription');


        new RangeExpression($baseExpressionMock, 'test/bla');
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenTooManyValues_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn(0);
        $baseExpressionMock->shouldReceive('getMax')->andReturn(1);
        $baseExpressionMock->shouldReceive('getDescription');


        new RangeExpression($baseExpressionMock, '1-2-3');
    }


    public function testConstruct_AcceptsAsteriskAsRange()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn(0);
        $baseExpressionMock->shouldReceive('getMax')->andReturn(10);
        $baseExpressionMock->shouldReceive('getDescription');


        $expr = new RangeExpression($baseExpressionMock, '*/2');
        for ($i = 0; $i <= 10; $i++) {
            $this->assertEquals($i%2 == 0, $expr->matches($i));
        }
    }
}
