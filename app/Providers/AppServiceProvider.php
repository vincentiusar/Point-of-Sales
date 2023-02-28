<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\impl\AuthServiceImpl;
use App\Services\Food\FoodService;
use App\Services\Food\impl\FoodServiceImpl;
use App\Services\Restaurant\impl\RestaurantServiceImpl;
use App\Services\Restaurant\RestaurantService;
use App\Services\Table\impl\TableServiceImpl;
use App\Services\Table\TableService;
use App\Services\Transaction\impl\TransactionServiceImpl;
use App\Services\Transaction\TransactionService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(RestaurantService::class, RestaurantServiceImpl::class);
        $this->app->bind(TableService::class, TableServiceImpl::class);
        $this->app->bind(FoodService::class, FoodServiceImpl::class);
        $this->app->bind(TransactionService::class, TransactionServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $model_name) {
            $namespace = '\\Database\\Factories\\';
            $model_name = Str::afterLast($model_name, '\\');
            return $namespace . $model_name . 'Factory';
        });
    }
}
