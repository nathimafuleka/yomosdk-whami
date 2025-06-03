<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Whami Keywords Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for configuring the keywords used for Whami link tracking.
    | Keywords are used in the format {keyword}_{attributioncode} to track
    | user interactions and show specific bot views in WhatsApp.
    |
    */

    'keywords' => [
        'whatsapp' => [
            # Your WhatsApp-specific keywords here
        ],
        'ussd' => [
            # Your USSD-specific keywords here
        ],
        'messenger' => [
            # Your Messenger-specific keywords here
        ],
        'global' => [
            # Keywords that are registered irrespective of channel or context
        ]
    ]
];
