<?php

namespace CronVis\Cron;

use CronVis\Parser\Tokenizer;
use CronVis\Parser\Matcher\Regex as RegexMatcher;
use CronVis\Parser\Matcher\String as StringMatcher;

class CronTokenizer extends Tokenizer
{
    public function __construct()
    {
        $this->setTerminals([
            CronToken::WHITESPACE       => new RegexMatcher('\s+'),
            CronToken::MARK_HASH        => new StringMatcher('#'),
            CronToken::MARK_NO_INPUT    => new StringMatcher('\\%'),
            CronToken::MARK_INPUT       => new StringMatcher('%'),
            CronToken::AT_YEARLY        => new RegexMatcher('@yearly|@annually'),
            CronToken::AT_MONTHLY       => new StringMatcher('@monthly'),
            CronToken::AT_WEEKLY        => new StringMatcher('@weekly'),
            CronToken::AT_DAILY         => new StringMatcher('@daily'),
            CronToken::AT_HOURLY        => new StringMatcher('@hourly'),
            CronToken::AT_REBOOT        => new StringMatcher('@reboot'),
            CronToken::DIGIT_ZERO       => new StringMatcher('0'),
            CronToken::DIGIT_LOW        => new RegexMatcher('[1-5]'),
            CronToken::DIGIT_SIX        => new StringMatcher('6'),
            CronToken::DIGIT_HIGH       => new RegexMatcher('[7-9]'),
            CronToken::STRING_DOW       => new RegexMatcher('MON|TUE|WED|THU|FRI|SAT|SUN'),
            CronToken::STRING_MONTH     => new RegexMatcher('JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC'),
            CronToken::MARK_SLASH       => new StringMatcher('/'),
            CronToken::MARK_DASH        => new StringMatcher('-'),
            CronToken::MARK_ASTERISK    => new StringMatcher('*'),
            CronToken::MARK_COMMA       => new StringMatcher(','),
            CronToken::OTHER            => new RegexMatcher('[^\s#%\\\]*')
        ]);
    }
}
