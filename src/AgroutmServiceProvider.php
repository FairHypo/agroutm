<?php

namespace Fairhypo\Agroutm;

use Illuminate\Support\ServiceProvider;

class AgroutmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //Указываем что пакет должен опубликовать при установке
        $this->publishes([__DIR__ . '/../database/' => base_path("database")], 'database');
    }

    public function register()
    {
        //
    }
}