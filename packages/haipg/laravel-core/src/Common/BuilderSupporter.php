<?php

namespace HaiPG\LaravelCore\Common;

class BuilderSupporter
{
    /**
     * Make a query to multiple updating
     *
     * @param string $table
     * @param array $data - Data example: $data[$columnUpdated][] = [$columnConditionValue, $valueWillUpdate]
     * @param string $columnCondition
     *
     * @return string
     */
    public static function makeMultipleUpdate(string $table, array $data, string $columnCondition = 'id')
    {
        $query = 'UPDATE %s SET %s WHERE %s IN (%s)';
        $columns = [];
        $columnConditionValues = [];

        collect($data)->each(function ($values, $column) use (&$columns, &$columnConditionValues, $columnCondition) {
            $sub = $column . ' = CASE';

            collect($values)->each(function ($value) use (&$sub, &$columnConditionValues, $columnCondition) {
                $sub .= ' WHEN ' . $columnCondition . ' = ' . $value[0] . ' THEN ' . $value[1];
                $columnConditionValues[] = $value[0];
            });

            $columns[] = $sub . ' ELSE ' . $column . ' END';
        });

        $columns               = join(',', $columns);
        $columnConditionValues = join(',', array_unique($columnConditionValues));

        return sprintf($query, $table, $columns, $columnCondition, $columnConditionValues);
    }
}
