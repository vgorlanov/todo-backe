<?php

namespace App\Providers;

use App\Library\Order\Order;
use App\Library\Order\TableOrder;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Order::class, function ($app) {
            return new TableOrder();
        });
    }
}
