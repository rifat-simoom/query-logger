<?php

namespace RifatSimoom\QueryLogger\Helpers;

class Formatter
{
    public static function formatQuery(array $bindings, string $query): string
    {
        foreach ($bindings as $binding) {
            $query = preg_replace('/\?/', "'$binding'", $query, 1);
        }
        return $query;
    }
}
