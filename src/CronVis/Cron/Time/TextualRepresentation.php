<?php


namespace CronVis\Cron\Time;

trait TextualRepresentation
{
    /**
     * @param   string   $input
     * @param   string[] $validInputs
     *
     * @return  boolean
     */
    protected function _isValidTextualRepresentation($input, array $validInputs = [])
    {
        $input = strtolower($input);

        $mapFunction = function ($weekDay) use ($input) {
            return strpos(strtolower($input), $weekDay) === 0;
        };

        $reduceFunction = function ($carry, $input) {
            return $carry | $input;
        };

        return array_reduce(
            array_map($mapFunction, $validInputs),
            $reduceFunction,
            false
        );
    }

    /**
     * @param   string   $input
     * @param   string[] $validInputs
     *
     * @return  int
     */
    protected function _getTextualRepresentationOffset($input, array $validInputs = [])
    {
        return array_search(
            substr(
                strtolower($input),
                0,
                3
            ), $validInputs
        ) + 1;
    }
}
