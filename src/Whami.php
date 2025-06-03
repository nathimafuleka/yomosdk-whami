<?php

namespace Yomo7\Whami;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

/**
 * @method void eventOnKeywordReceived(string $keyword, string $attributionCode, string $number)
 */
abstract class Whami
{
    /**
     * Parse a keyword string in the format {keyword}_{attributioncode}
     *
     * @param string $input The input string to parse
     * @return array|null Returns [keyword, attributionCode] or null if invalid format
     */
    public static function parseKeyword(string $input): ?array
    {
        // Check if the input matches the expected format
        if (preg_match('/^([a-zA-Z0-9]+)_([a-zA-Z0-9]+)$/', $input, $matches)) {
            return [
                'keyword' => $matches[1],
                'attributionCode' => $matches[2]
            ];
        }
        
        // If the input is just a keyword without attribution code
        if (preg_match('/^([a-zA-Z0-9]+)$/', $input, $matches)) {
            return [
                'keyword' => $matches[1],
                'attributionCode' => null
            ];
        }
        
        return null;
    }
    
    /**
     * Process a keyword and track it in the database
     *
     * @param string $input The input string in format {keyword}_{attributioncode}
     * @param string|null $number The user's phone number
     * @return array|null Returns the parsed keyword data or null if invalid
     */
    public static function processKeyword(string $input, ?string $number = null): ?array
    {
        $parsed = self::parseKeyword($input);
        
        if ($parsed) {
            // Save to database
            DB::table('whami_keywords')->insert([
                'number' => $number,
                'keyword' => $parsed['keyword'],
                'attribution_code' => $parsed['attributionCode'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Fire event
            self::fire('OnKeywordReceived', [$parsed['keyword'], $parsed['attributionCode'], $number]);
            
            return $parsed;
        }
        
        return null;
    }
    
    /**
     * Check if a keyword exists in the configuration
     *
     * @param string $keyword The keyword to check
     * @param string|null $channel The channel to check in (or null for global)
     * @return bool
     */
    public static function keywordExists(string $keyword, ?string $channel = null): bool
    {
        if ($channel) {
            return in_array($keyword, config("whami.keywords.{$channel}", []));
        }
        
        // Check in all channels
        foreach (config('whami.keywords') as $channelKeywords) {
            if (in_array($keyword, $channelKeywords)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Fires an internal event, which can be trapped by functions of a Whami class
     *
     * @param string $event The name of the event (e.g. "OnKeywordReceived")
     * @param array|null $payload Optional data to be passed to the handling Whami class function
     */
    public static function fire(string $event, ?array $payload = null)
    {
        if (WhamiKeywordSubscriber::keywordHandlerExists($event)) {
            Event::dispatch($event, $payload);
        }
    }
}
