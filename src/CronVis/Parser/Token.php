<?php

namespace CronVis\Parser;

class Token
{
    const WHITESPACE    = 'T_WHITESPACE';
    const MARK_NULL     = 'T_MARK_NULL';
    public static $NULL_TOKEN = [self::MARK_NULL];
}
