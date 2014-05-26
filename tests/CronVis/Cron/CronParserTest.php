<?php


namespace CronVis\Cron;


use CronVis\Parser\ParseException;
use CronVis\Util\StringLineSource;
use Exception;

class CronParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseComment()
    {
        $input = <<<EOF
# This is a comment
EOF;

        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        $output = $cronParser->parseLine($input);


        $this->assertEquals([
            CronToken::EXPR_LINE => [ CronToken::EXPR_COMMENT => "This is a comment" ]
        ], $output);
    }

    public function testParse_EmptyLine_Returns_NullToken()
    {
        $input = <<<EOF
EOF;

        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        $output = $cronParser->parseLine($input);


        $this->assertEquals([
            CronToken::EXPR_LINE => CronToken::$NULL_TOKEN
        ], $output);
    }

    /**
     * @expectedException \CronVis\Parser\ParseException
     */
    public function testParse_UnexptectedToken_ThrowsException()
    {
        $input = <<<EOF
% this is not supposed to happen
EOF;

        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        iterator_to_array($cronParser->parseLines());
    }

    public function testParseAtDailyExpression()
    {
        $input =  <<<EOF
@daily /execute/this/command >/dev/null 2>&1
EOF;
        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        $output = $cronParser->parseLine($input);

        $this->assertEquals([
            CronToken::EXPR_LINE => [
                CronToken::EXPR_TIME    => [CronToken::EXPR_AT => '@daily'],
                CronToken::EXPR_COMMAND => '/execute/this/command >/dev/null 2>&1'
            ]
        ], $output);
    }

    public function testParseTimeExpression()
    {
        $input = <<<EOF
* * * * * /this/cant/work.sh
EOF;
        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        $tokens = array();
        foreach ($cronParser->parseLines() as $lineTokens) {
            $tokens[] = $lineTokens;
        }


        $this->assertEquals([[
            CronToken::EXPR_LINE => [
                CronToken::EXPR_TIME  => [
                    CronToken::EXPR_MINUTE    => '*',
                    CronToken::EXPR_HOUR      => '*',
                    CronToken::EXPR_DOM       => '*',
                    CronToken::EXPR_MONTH     => '*',
                    CronToken::EXPR_DOW       => '*'
                ],
                CronToken::EXPR_COMMAND       => '/this/cant/work.sh'
            ]
        ]], $tokens);
    }

    public function testParseTimeExpression_WithInputAndComment()
    {
        $input = <<<EOF
* * * * * /this/cant/work.sh % this is input yo # and this is a comment
EOF;
        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        $tokens = array();
        foreach ($cronParser->parseLines() as $lineTokens) {
            $tokens[] = $lineTokens;
        }


        $this->assertEquals([[
            CronToken::EXPR_LINE => [
                CronToken::EXPR_TIME  => [
                    CronToken::EXPR_MINUTE  => '*',
                    CronToken::EXPR_HOUR    => '*',
                    CronToken::EXPR_DOM     => '*',
                    CronToken::EXPR_MONTH   => '*',
                    CronToken::EXPR_DOW     => '*'
                ],
                CronToken::EXPR_COMMAND     => '/this/cant/work.sh',
                CronToken::EXPR_INPUT       => 'this is input yo',
                CronToken::EXPR_COMMENT     => 'and this is a comment'
            ]
        ]], $tokens);
    }

    public function testParseTimeExpression_WithEscapedInputAndComment()
    {
        $input = <<<EOF
* * * * * /this/cant/work.sh \% this is no input # and this is a comment
EOF;
        $lineSource = new StringLineSource($input);
        $cronParser = new CronParser($lineSource);


        $tokens = array();
        foreach ($cronParser->parseLines() as $lineTokens) {
            $tokens[] = $lineTokens;
        }


        $this->assertEquals([[
            CronToken::EXPR_LINE => [
                CronToken::EXPR_TIME  => [
                    CronToken::EXPR_MINUTE  => '*',
                    CronToken::EXPR_HOUR    => '*',
                    CronToken::EXPR_DOM     => '*',
                    CronToken::EXPR_MONTH   => '*',
                    CronToken::EXPR_DOW     => '*'
                ],
                CronToken::EXPR_COMMAND     => '/this/cant/work.sh \% this is no input',
                CronToken::EXPR_COMMENT     => 'and this is a comment'
            ]
        ]], $tokens);
    }
}
 