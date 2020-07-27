<?php

namespace TS2201\VuePageReview\Facades;

use Illuminate\Support\Facades\Facade;

class VuePageReview extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vuepagereview';
    }
}
