<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Historical Price Tracking
    |--------------------------------------------------------------------------
    |
    | If set to false, no historical prices will be recorded. Useful if
    | the feature is not needed in certain environments or scenarios.
    |
    */
    'enabled' => true,

    /*
     |--------------------------------------------------------------------------
     | Tracking Mode
     |--------------------------------------------------------------------------
     |
     | - 'all': Record every price change as historical data.
     | - 'latest': Only store the latest price, discarding any prior data.
     |
     */
    'tracking_mode' => 'all',
];
