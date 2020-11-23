<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//category contract and repository
use App\Contracts\CategoryContract;
use App\Repositories\CategoryRepository;
//attribute contract and repository
use App\Contracts\AttributeContract;
use App\Repositories\AttributeRepository;
/*****BRAND CONTRACT AND REPOSITORY */
use App\Contracts\BrandContract;
use App\Repositories\BrandRepository;
//Product contract and repository
use App\Contracts\ProductContract;
use App\Repositories\ProductRepository;
//order contract and repository
use App\Contracts\OrderContract;
use App\Repositories\OrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CategoryContract::class         =>          CategoryRepository::class,
        AttributeContract::class        =>          AttributeRepository::class,
        BrandContract::class            =>          BrandRepository::class,
        ProductContract::class          =>          ProductRepository::class,
        OrderContract::class            =>          OrderRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
