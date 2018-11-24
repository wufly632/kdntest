<?php

namespace App\Providers;

use App\Entities\Product\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //导入文件
        $this->import();
        // // 模型监听
        // Product::observe(ProductObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        \Blade::directive('php', function($expression) {
            return "<?php  $expression; ?>";
        });
    }

    /**
     * 引入自定义的头文件
     *
     * @return void
     */
    private function import()
    {
        require_once app_path().'/Helpers/header.php';
    }
}
