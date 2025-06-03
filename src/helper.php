<?php

if (!function_exists('whami_process')) {
    /**
     * Process a Whami keyword string and track it
     *
     * @param string $input The input string in format {keyword}_{attributioncode}
     * @param string|null $number The user's phone number
     * @return array|null
     */
    function whami_process(string $input, ?string $number = null): ?array
    {
        return \Yomo7\Whami\Whami::processKeyword($input, $number);
    }
}

if (!function_exists('whami_parse')) {
    /**
     * Parse a Whami keyword string without tracking
     *
     * @param string $input The input string in format {keyword}_{attributioncode}
     * @return array|null
     */
    function whami_parse(string $input): ?array
    {
        return \Yomo7\Whami\Whami::parseKeyword($input);
    }
}
