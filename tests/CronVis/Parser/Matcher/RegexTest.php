<?php


namespace CronVis\Parser\Matcher;


class RegexTest extends \PHPUnit_Framework_TestCase
{
    public function testMatches()
    {
        $regex = new Regex('hello');
        $input = 'hello world';


        $match = $regex->matches($input);


        $this->assertEquals('hello', $match);
    }

    public function testMatches_givenNonMatchingString_returnsFalse()
    {
        $regex = new Regex('hallo');
        $input = 'hello world';


        $match = $regex->matches($input);


        $this->assertFalse($match);
    }
}
 