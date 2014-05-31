<?php


namespace CronVis\Cron;


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

    public function findMatch(\DateTime $dateTime)
    {
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

        return $dateTime;
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
        return new TimeExpression(
            new MinuteExpression($tokens[CronToken::EXPR_MINUTE]),
            new HourExpression($tokens[CronToken::EXPR_HOUR]),
            new DayOfMonthExpression($tokens[CronToken::EXPR_DOM]),
            new MonthExpression($tokens[CronToken::EXPR_MONTH]),
            new DayOfWeekExpression($tokens[CronToken::EXPR_DOW])
        );
    }
}
