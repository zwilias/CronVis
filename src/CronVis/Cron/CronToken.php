<?php

namespace CronVis\Cron;

use CronVis\Parser\Token;

class CronToken extends Token
{
    const MARK_HASH     = 'T_MARK_HASH';
    const MARK_ESCAPE   = 'T_MARK_ESCAPE';
    const MARK_NO_INPUT = 'T_MARK_NO_INPUT';
    const MARK_INPUT    = 'T_MARK_INPUT';
    const MARK_SLASH    = 'T_MARK_SLASH';
    const MARK_DASH     = 'T_MARK_DASH';
    const MARK_ASTERISK = 'T_MARK_ASTERISK';
    const MARK_COMMA    = 'T_MARK_COMMA';

    const AT_YEARLY  = 'T_AT_YEARLY';
    const AT_MONTHLY = 'T_AT_MONTHLY';
    const AT_WEEKLY  = 'T_AT_WEEKLY';
    const AT_DAILY   = 'T_AT_DAILY';
    const AT_HOURLY  = 'T_AT_HOURLY';
    const AT_REBOOT  = 'T_AT_REBOOT';

    const DIGIT_ZERO = 'T_DIGIT_ZERO';
    const DIGIT_LOW  = 'T_DIGIT_LOW';
    const DIGIT_SIX  = 'T_DIGIT_SIX';
    const DIGIT_HIGH = 'T_DIGIT_HIGH';

    const STRING_DOW   = 'T_STRING_DOW';
    const STRING_MONTH = 'T_STRING_MONTH';

    const OTHER = 'T_OTHER';

    const EXPR_LINE    = 'T_LINE';
    const EXPR_COMMENT = 'T_COMMENT';
    const EXPR_INPUT   = 'T_INPUT';
    const EXPR_COMMAND = 'T_COMMAND';
    const EXPR_TIME    = 'T_TIME_EXPRESSION';
    const EXPR_AT      = 'T_AT_EXPRESSION';
    const EXPR_MINUTE  = 'T_MINUTE_EXPRESSION';
    const EXPR_HOUR    = 'T_HOUR_EXPRESSION';
    const EXPR_DOM     = 'T_DOM_EXPRESSION';
    const EXPR_MONTH   = 'T_MONTH_EXPRESSION';
    const EXPR_DOW     = 'T_DOW_EXPRESSION';
}
