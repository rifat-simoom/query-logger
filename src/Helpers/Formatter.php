<?php

namespace RifatSimoom\QueryLogger\Helpers;

class Formatter
{
    public static function formatQuery(array $bindings, string $query): string
    {
        foreach ($bindings as $binding) {
            $escapedBinding = preg_quote($binding, '/');
            $query = preg_replace('/\?/', "'$escapedBinding'", $query, 1);
        }
        return $query;
    }
}
