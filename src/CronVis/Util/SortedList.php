<?php

namespace CronVis\Util;

use Countable;

abstract class SortedList implements Countable
{
    /**
     * @var mixed[]
     */
    protected $_internalList = array();

    /**
     * @param mixed $item
     */
    public function add($item)
    {
        $atIndex = 0;
        while (
            count($this->_internalList) >= $atIndex + 1 &&
            $this->_compare($this->_internalList[$atIndex], $item) <= 0
        ) {
            $atIndex += 1;
        }

        $this->_insertAtIndex($atIndex, $item);
    }

    /**
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->_internalList);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->_internalList);
    }

    /**
     * @param int $index
     * @param mixed $item
     */
    protected function _insertAtIndex($index, $item)
    {
        $after = array_splice($this->_internalList, $index);
        $this->_internalList[] = $item;
        $this->_internalList = array_merge($this->_internalList, $after);
    }

    /**
     * Returns a negative integer if $a comes before $b, 0 if they are considered equal, and a strictly positive integer if $a comes after $b
     *
     * @param mixed $a
     * @param mixed $b
     * @return int
     */
    abstract protected function _compare($a, $b);
}
