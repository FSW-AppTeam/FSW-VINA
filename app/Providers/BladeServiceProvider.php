<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Blade::directive('bladedebug', function ($text) {
            if (config('app.debug')) {
                return "<div style='color: red'><?php echo $text; ?></div>";
            }
        });


        Blade::directive('ray', function ($text) {
            if (config('app.debug')) {
                return "<?php ray($text); ?>";
            }
        });

        Blade::directive('ribbon', function ($text) {
            if (config('app.debug') || !str_starts_with(config('app.env'), 'prod')){
                return "<div class='ribbon-wrapper-green'>
                            <div class='ribbon-green'>
                                <p>Environment: {{config('app.env')}}</p>
                                <p>Debugmode {{config('app.debug')}}</p>
                            </div>
                        </div>";
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
