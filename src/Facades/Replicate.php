<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev|https://twitter.com/aarondfrancis>
 */

namespace D4veR\Replicate\Facades;

use D4veR\Replicate\Replicate as Client;
use Illuminate\Support\Facades\Facade;

class Replicate extends Facade
{
    /**
     * @see Manager
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}