<?php


namespace CronVis\Cron\Time\Common;


use Mockery;

class ListExpressionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenANonConvertedValue_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression');
        $baseExpressionMock->shouldReceive('preProcessNumber')->andReturn('hi');
        $baseExpressionMock->shouldReceive('getMin')->andReturn(0);
        $baseExpressionMock->shouldReceive('getMax')->andReturn(1);
        $baseExpressionMock->shouldReceive('getDescription');


        new ListExpression($baseExpressionMock, 'test');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenAValueHigherThanMax_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn(0);
        $baseExpressionMock->shouldReceive('getMax')->andReturn(1);
        $baseExpressionMock->shouldReceive('getDescription');


        new ListExpression($baseExpressionMock, 5);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstruct_GivenAValueLowerThanMin_Fails()
    {
        $baseExpressionMock = \Mockery::mock('\CronVis\Cron\Time\BaseExpression')->shouldDeferMissing();
        $baseExpressionMock->shouldReceive('getMin')->andReturn(0);
        $baseExpressionMock->shouldReceive('getMax')->andReturn(1);
        $baseExpressionMock->shouldReceive('getDescription');


        new ListExpression($baseExpressionMock, -5);
    }
}
