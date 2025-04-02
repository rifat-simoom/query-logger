<?php

namespace RifatSimoom\QueryLogger\Helpers;

class Formatter
{
    public static function formatQuery(array $bindings, string $query): string
    {
        // Find all positions of "?" in the query
        $positions = [];
        $offset = 0;
        while (($pos = strpos($query, '?', $offset)) !== false) {
            $positions[] = $pos;
            $offset = $pos + 1;
        }

        for ($i = count($positions) - 1; $i >= 0; $i--) {
            if (isset($bindings[$i])) {
                $binding = $bindings[$i];
                $query = substr_replace($query, "'$binding'", $positions[$i], 1);
            }
        }

        return $query;
    }
}
