<?php

namespace CronVis\Parser;

class Token
{
    const KEY_TOKEN     = 0;
    const KEY_CONTENT   = 1;
    const KEY_OFFSET    = 2;

    const WHITESPACE    = 'T_WHITESPACE';
    const MARK_NULL     = 'T_MARK_NULL';
    public static $NULL_TOKEN = [self::MARK_NULL];
}
