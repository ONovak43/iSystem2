<?php

namespace App\Providers;

use App\Observers\EventObserver;
use App\Repositories\RESTStagRepository;
use App\Repositories\StagRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\CacheMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            StagRepositoryInterface::class,
            RESTStagRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('cs');
        $stack = HandlerStack::create();

        $stack->push(
            new CacheMiddleware(
                new GreedyCacheStrategy (
                    new LaravelCacheStorage(
                        Cache::store('file')
                    ), 1800
                )
            ),
            'cache'
        );
        $default = ["verify" => __DIR__ . "/cacert.pem"];
        $this->app->singleton(Client::class, function() use ($stack){
            return new Client([
                'base_uri' => config('services.stag.uri'),
                'handler' => $stack,
                'verify' => base_path() .  "/cacert.pem"
            ]);
        });
    }
}
