<?php
/**
 * Created by PhpStorm.
 * User: ilias
 * Date: 26/05/14
 * Time: 22:46
 */

namespace CronVis\Util;


class SortedListTest extends \PHPUnit_Framework_TestCase
{
    public function testAddItems_ShiftSorted()
    {
        $sortedList = new SortedList(new IntegerComparator());
        $integers = range(0, 10);
        shuffle($integers);

        foreach ($integers as $integer) {
            $sortedList->add($integer);
        }


        $output = [];
        while ($sortedList->count() > 0) {
            $output[] = $sortedList->shift();
        }


        sort($integers);
        $this->assertEquals($integers, $output);
    }
}

class IntegerComparator implements Comparator
{
    /**
     * @param mixed $a
     * @param mixed $b
     * @return int|mixed
     */
    public function compare($a, $b)
    {
        return $a - $b;
    }
}