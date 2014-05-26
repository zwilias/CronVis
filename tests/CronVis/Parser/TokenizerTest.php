<?php


namespace CronVis\Parser;


class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    public function testTokenizeLine()
    {
        $terminals = array(
            'T_WHITESPACE'  => new Matcher\Regex('\s+'),
            'T_WORD'        => new Matcher\Regex('[a-z]+')
        );

        $input = "hello world";
        $tokenizer = new Tokenizer();
        $tokenizer->setTerminals($terminals);


        $tokens = $tokenizer->tokenizeLine($input);


        $this->assertEquals(array(
            array('T_WORD',         'hello',    0),
            array('T_WHITESPACE',   ' ',        5),
            array('T_WORD',         'world',    6)
        ), $tokens);
    }
}
 