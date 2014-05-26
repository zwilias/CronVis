<?php


namespace CronVis\Cron;


class CronTokenizerTest extends \PHPUnit_Framework_TestCase
{
    public function testTokenizeLine()
    {
        $input = "@daily /run/this/command % withinput # and a comment";
        $tokenizer = new CronTokenizer();


        $output = $tokenizer->tokenizeLine($input);


        $expected = array(
            array(CronToken::AT_DAILY,      '@daily',            0),
            array(CronToken::WHITESPACE,    ' ',                 6),
            array(CronToken::MARK_SLASH,    '/',                 7),
            array(CronToken::OTHER,         'run/this/command',  8),
            array(CronToken::WHITESPACE,    ' ',                24),
            array(CronToken::MARK_INPUT,    '%',                25),
            array(CronToken::WHITESPACE,    ' ',                26),
            array(CronToken::OTHER,         'withinput',        27),
            array(CronToken::WHITESPACE,    ' ',                36),
            array(CronToken::MARK_HASH,     '#',                37),
            array(CronToken::WHITESPACE,    ' ',                38),
            array(CronToken::OTHER,         'and',              39),
            array(CronToken::WHITESPACE,    ' ',                42),
            array(CronToken::OTHER,         'a',                43),
            array(CronToken::WHITESPACE,    ' ',                44),
            array(CronToken::OTHER,         'comment',          45),
        );
        $this->assertEquals($expected, $output);
    }
}
 