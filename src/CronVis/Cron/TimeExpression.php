<?php


namespace CronVis\Cron;


use CronVis\Cron\Time\BaseExpression;
use CronVis\Cron\Time\DayOfMonthExpression;
use CronVis\Cron\Time\DayOfWeekExpression;
use CronVis\Cron\Time\HourExpression;
use CronVis\Cron\Time\MinuteExpression;
use CronVis\Cron\Time\MonthExpression;

class TimeExpression
{
    /** @var \CronVis\Cron\Time\MinuteExpression  */
    protected $_minutes;
    /** @var \CronVis\Cron\Time\HourExpression  */
    protected $_hours;
    /** @var \CronVis\Cron\Time\DayOfMonthExpression  */
    protected $_dayOfMonth;
    /** @var \CronVis\Cron\Time\DayOfWeekExpression  */
    protected $_dayOfWeek;
    /** @var \CronVis\Cron\Time\MonthExpression  */
    protected $_month;

    public function __construct(
        MinuteExpression        $minuteExpression,
        HourExpression          $hourExpression,
        DayOfMonthExpression    $dayOfMonthExpression,
        MonthExpression         $monthExpression,
        DayOfWeekExpression     $dayOfWeekExpression
    ) {
        $this->_minutes     = $minuteExpression;
        $this->_hours       = $hourExpression;
        $this->_dayOfMonth  = $dayOfMonthExpression;
        $this->_dayOfWeek   = $dayOfWeekExpression;
        $this->_month       = $monthExpression;
    }

    /**
     * @param \DateTimeImmutable $dateTime
     *
     * @return \DateTimeImmutable
     */
    public function findMatch(\DateTimeImmutable $dateTime)
    {
        $dateTime = new \DateTime($dateTime->format('c'));
        while (!$this->matches($dateTime)) {
            while (!$this->_month->matches($dateTime)) {
                $dateTime->modify($this->_month->getIncrement($dateTime));
            }

            if ($this->_dayOfWeek->isAny() && !$this->_dayOfMonth->matches($dateTime)) {
                $dateTime->modify($this->_dayOfMonth->getIncrement($dateTime));
            } elseif ($this->_dayOfMonth->isAny() && !$this->_dayOfWeek->matches($dateTime)) {
                $dateTime->modify($this->_dayOfWeek->getIncrement($dateTime));
            } elseif (!($this->_dayOfMonth->matches($dateTime) || $this->_dayOfWeek->matches($dateTime))) {
                $increment = $this->_dayOfMonth->getRawIncrement($dateTime) < $this->_dayOfWeek->getRawIncrement($dateTime)
                    ? $this->_dayOfMonth->getIncrement($dateTime)
                    : $this->_dayOfWeek->getIncrement($dateTime);

                $dateTime->modify($increment);
            }

            while (!$this->_hours->matches($dateTime)) {
                $dateTime->modify($this->_hours->getIncrement($dateTime));
            }

            while (!$this->_minutes->matches($dateTime)) {
                $dateTime->modify($this->_minutes->getIncrement($dateTime));
            }
        }

        return new \DateTimeImmutable($dateTime->format('c'));
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function matches(\DateTime $dateTime)
    {
        return $this->_month->matches($dateTime)
            && (
                ($this->_dayOfWeek->isAny() && $this->_dayOfMonth->isAny()) ||
                ($this->_dayOfWeek->isAny() && $this->_dayOfMonth->matches($dateTime)) ||
                ($this->_dayOfMonth->isAny() && $this->_dayOfWeek->matches($dateTime)) ||
                !($this->_dayOfMonth->isAny() || $this->_dayOfWeek->isAny()) &&
                    (
                        $this->_dayOfMonth->matches($dateTime) || $this->_dayOfWeek->matches($dateTime)
                    )
            )
            && $this->_hours->matches($dateTime)
            && $this->_minutes->matches($dateTime);
    }

    public static function factory($tokens)
    {
        if (isset($tokens[CronToken::EXPR_AT])) {
            $hourPart       = BaseExpression::ANY;
            $dayOfMonthPart = BaseExpression::ANY;
            $monthPart      = BaseExpression::ANY;
            $dayOfWeekPart  = BaseExpression::ANY;

            switch ($tokens[CronToken::EXPR_AT]) {
                case CronToken::AT_WEEKLY:
                    $minutePart = '0';
                    $hourPart = '0';
                    $dayOfWeekPart = '0';
                    break;
                /** @noinspection PhpMissingBreakStatementInspection */
                case CronToken::AT_YEARLY:
                    $monthPart = '1';
                /** @noinspection PhpMissingBreakStatementInspection */
                case CronToken::AT_MONTHLY:
                    $dayOfMonthPart = '1';
                /** @noinspection PhpMissingBreakStatementInspection */
                case CronToken::AT_DAILY:
                    $hourPart = '0';
                case CronToken::AT_HOURLY:
                    $minutePart = '0';
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Unrecognized @format: %s', $tokens[CronToken::EXPR_AT]));
            }
        } else {
            $minutePart = $tokens[CronToken::EXPR_MINUTE];
            $hourPart = $tokens[CronToken::EXPR_HOUR];
            $dayOfMonthPart = $tokens[CronToken::EXPR_DOM];
            $monthPart = $tokens[CronToken::EXPR_MONTH];
            $dayOfWeekPart = $tokens[CronToken::EXPR_DOW];
        }

        return new TimeExpression(
            new MinuteExpression($minutePart),
            new HourExpression($hourPart),
            new DayOfMonthExpression($dayOfMonthPart),
            new MonthExpression($monthPart),
            new DayOfWeekExpression($dayOfWeekPart)
        );
    }
}
