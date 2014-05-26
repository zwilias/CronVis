<?php


namespace CronVis\Util;


interface LineSource
{
    /** @return \Generator<string> */
    function getLines();
} 