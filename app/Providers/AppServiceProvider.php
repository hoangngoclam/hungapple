<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\Image;
use Optix\Media\Facades\Conversion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Create thumbnail image
        Conversion::register('thumb', function (Image $image) {
            return $image->fit(200, 200);
        });
        // Create preview image
        Conversion::register('preview', function (Image $image) {
            return $image->fit(600, 600);
        });
    }
}
