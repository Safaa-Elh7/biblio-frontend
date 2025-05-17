<?php

namespace App\Providers;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // Ajouter une directive Blade personnalisée pour les images
        Blade::directive('bookImage', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::getImageUrl($expression); ?>";
        });
    }
}
