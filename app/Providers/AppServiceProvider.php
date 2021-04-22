<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('version', function ($expression) {

            $filename = public_path().$expression;
            if (file_exists($filename)) {
                $string = '<?php echo "'.$expression.'?'.filemtime($filename).'"; ?>';
                return $string;
            }
            else {
                $string = '<?php echo "'.$expression.'"; ?>';
                return $string;
            }
        });
    }
}
