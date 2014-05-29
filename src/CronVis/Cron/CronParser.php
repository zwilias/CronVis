<?php


namespace CronVis\Cron;

use CronVis\Parser\Parser;
use CronVis\Parser\Tokenizer;

class CronParser extends Parser
{
    /**
     * @return Tokenizer
     */
    protected function _getTokenizer()
    {
        return new CronTokenizer();
    }

    /**
     * @return array[]
     */
    protected function _parseTokens()
    {
        $lineResult = $this->handleLine();
        return [CronToken::EXPR_LINE => $lineResult];
    }

    /**
     * @return array[]
     */
    public function handleLine()
    {
        $token = $this->_peek();
        $result = null;

        switch ($token[Tokenizer::KEY_TOKEN]) {
            case CronToken::MARK_NULL:
                $result = $token;
                break;
            case CronToken::MARK_HASH:
                $result = $this->buildSimpleExpression(CronToken::EXPR_COMMENT, [CronToken::MARK_HASH]);
                break;
            case CronToken::AT_YEARLY:
            case CronToken::AT_MONTHLY:
            case CronToken::AT_WEEKLY:
            case CronToken::AT_DAILY:
            case CronToken::AT_HOURLY:
            case CronToken::AT_REBOOT:
                $result = $this->buildCronExpression(
                    $this->buildSimpleExpression(CronToken::EXPR_AT, [
                        CronToken::AT_YEARLY, CronToken::AT_MONTHLY, CronToken::AT_WEEKLY,
                        CronToken::AT_DAILY, CronToken::AT_HOURLY, CronToken::AT_REBOOT
                    ], [CronToken::WHITESPACE], false)
                );
                break;
            case CronToken::DIGIT_ZERO:
            case CronToken::DIGIT_LOW:
            case CronToken::DIGIT_SIX:
            case CronToken::DIGIT_HIGH:
            case CronToken::MARK_ASTERISK:
                $result = $this->buildCronExpression($this->buildTimeExpression());
                break;
            default:
                $this->_throwUnexpectedTokenException($token);
        }

        return $result;
    }

    public function buildTimeExpression()
    {
        $timeExpression = array();

        $timeExpression[CronToken::EXPR_MINUTE] = $this->_combineTokens([CronToken::WHITESPACE]);
        $timeExpression[CronToken::EXPR_HOUR]   = $this->_combineTokens([CronToken::WHITESPACE]);
        $timeExpression[CronToken::EXPR_DOM]    = $this->_combineTokens([CronToken::WHITESPACE]);
        $timeExpression[CronToken::EXPR_MONTH]  = $this->_combineTokens([CronToken::WHITESPACE]);
        $timeExpression[CronToken::EXPR_DOW]    = $this->_combineTokens([CronToken::WHITESPACE]);

        return $timeExpression;
    }

    /**
     * @param   array $timeExpression
     * @return  array
     */
    public function buildCronExpression($timeExpression)
    {
        $cronExpression = [
            CronToken::EXPR_TIME    => $timeExpression,
            CronToken::EXPR_COMMAND => $this->_combineTokens([CronToken::MARK_HASH, CronToken::MARK_INPUT])
        ];

        while (($token = $this->_peek()) !== CronToken::$NULL_TOKEN) {
            switch ($token[Tokenizer::KEY_TOKEN]) {
                case CronToken::MARK_INPUT:
                    $cronExpression = array_merge(
                        $cronExpression,
                        $this->buildSimpleExpression(CronToken::EXPR_INPUT, [CronToken::MARK_INPUT], [CronToken::MARK_HASH])
                    );
                    break;
                case CronToken::MARK_HASH:
                    $cronExpression = array_merge(
                        $cronExpression,
                        $this->buildSimpleExpression(CronToken::EXPR_COMMENT, [CronToken::MARK_HASH])
                    );
                    break;
            }
        }

        return $cronExpression;
    }
}
