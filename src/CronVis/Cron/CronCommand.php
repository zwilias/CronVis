<?php


namespace CronVis\Cron;


class CronCommand
{
    protected $_command;

    public function __construct($command)
    {
        $this->_command = $command;
    }
}
