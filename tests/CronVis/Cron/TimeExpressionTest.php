<?php


namespace CronVis\Cron;


class TimeExpressionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideTimeExpressionData
     */
    public function testFindMatchWithData($timeTokens, $now, $expected)
    {
        $timeExpression = TimeExpression::factory($timeTokens);

        $now = new \DateTime($now);
        $expected = new \DateTime($expected);


        $this->assertEquals($expected, $timeExpression->findMatch($now));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFindMatch_UnknownAtType_Fails()
    {
        TimeExpression::factory([CronToken::EXPR_AT => '@whatisthis']);
    }

    public function provideTimeExpressionData()
    {
        return [
            'everythingValid' => [
                [
                    CronToken::EXPR_MINUTE    => '*',
                    CronToken::EXPR_HOUR      => '*',
                    CronToken::EXPR_DOM       => '*',
                    CronToken::EXPR_MONTH     => '*',
                    CronToken::EXPR_DOW       => '*'
                ],
                '2014-05-31 19:04',
                '2014-05-31 19:04'
            ],
            'dowAndDomBothSet' => [
                [
                    CronToken::EXPR_MINUTE    => '2',
                    CronToken::EXPR_HOUR      => '3',
                    CronToken::EXPR_DOM       => '4',
                    CronToken::EXPR_MONTH     => '10',
                    CronToken::EXPR_DOW       => '5'
                ],
                '2014-05-31 19:04',
                '2014-10-03 03:02'
            ],
            'dowAndDomBothSet2' => [
                [
                    CronToken::EXPR_MINUTE    => '2',
                    CronToken::EXPR_HOUR      => '3',
                    CronToken::EXPR_DOM       => '2',
                    CronToken::EXPR_MONTH     => '10',
                    CronToken::EXPR_DOW       => '5'
                ],
                '2014-05-31 19:04',
                '2014-10-02 03:02'
            ],
            'onlyDowRelevant' => [
                [
                    CronToken::EXPR_MINUTE    => '*',
                    CronToken::EXPR_HOUR      => '*',
                    CronToken::EXPR_DOM       => '*',
                    CronToken::EXPR_MONTH     => '*',
                    CronToken::EXPR_DOW       => '0'
                ],
                '2014-05-31 19:04',
                '2014-06-01 00:00'
            ],
            'onlyDomRelevant' => [
                [
                    CronToken::EXPR_MINUTE    => '*',
                    CronToken::EXPR_HOUR      => '*',
                    CronToken::EXPR_DOM       => '15',
                    CronToken::EXPR_MONTH     => '*',
                    CronToken::EXPR_DOW       => '*'
                ],
                '2014-05-31 19:04',
                '2014-06-15 00:00'
            ],
            'atYearly' => [
                [
                    CronToken::EXPR_AT  => CronToken::AT_YEARLY
                ],
                '2014-05-31 19:04',
                '2015-01-01 00:00'
            ],
            'atMonthly' => [
                [
                    CronToken::EXPR_AT  => CronToken::AT_MONTHLY
                ],
                '2014-05-31 19:04',
                '2014-06-01 00:00'
            ],
            'atWeekly' => [
                [
                    CronToken::EXPR_AT  => CronToken::AT_WEEKLY
                ],
                '2014-05-31 19:04',
                '2014-06-01 00:00'
            ],
            'atDaily' => [
                [
                    CronToken::EXPR_AT  => CronToken::AT_WEEKLY
                ],
                '2014-05-31 19:04',
                '2014-06-01 00:00'
            ]
        ];
    }
}
