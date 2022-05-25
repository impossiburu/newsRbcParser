<?php

namespace App\Providers;

use App\Services\ParserService;
use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register Parser Service
     * 
     * @return void
     */
    public function register()
    {
        $this->app->bind('parser', function() {
            return new ParserService();
        });
    }
}
