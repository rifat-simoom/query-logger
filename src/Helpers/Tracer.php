<?php

namespace RifatSimoom\QueryLogger\Helpers;

class Tracer
{
    public static function getFilteredTrace(): string
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $filteredTrace = [];

        foreach ($trace as $entry) {
            if (!isset($entry['file'], $entry['line'])) {
                continue;
            }

            if (self::isProjectFile($entry['file'])) {
                $filteredTrace[] = sprintf("%s:%d", $entry['file'], $entry['line']);
            }
        }

        return implode("\n", $filteredTrace);
    }

    private static function isProjectFile(string $filePath): bool
    {
        return !(
            strpos($filePath, 'vendor') !== false ||
            strpos($filePath, 'public') !== false ||
            strpos($filePath, 'server') !== false
        );
    }

}