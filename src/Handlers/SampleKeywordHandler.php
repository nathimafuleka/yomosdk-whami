<?php

namespace Yomo7\Whami\Handlers;

use Yomo7\Whami\Whami;

class SampleKeywordHandler extends Whami
{
    /**
     * Handle when a keyword is received
     * 
     * @param string $keyword The keyword that was received
     * @param string|null $attributionCode The attribution code (if any)
     * @param string|null $number The user's phone number (if available)
     */
    public function eventOnKeywordReceived(string $keyword, ?string $attributionCode, ?string $number)
    {
        // Here you can implement your custom logic for handling the keyword
        // For example, you might want to:
        // 1. Show a specific bot view in WhatsApp
        // 2. Trigger a specific flow
        // 3. Log the interaction for analytics
        
        // This is just a placeholder for your implementation
        logger()->info("Whami keyword received: {$keyword} with attribution code: {$attributionCode} from number: {$number}");
    }
}
