<?php

namespace App\Providers;
use App\Models\Admin;
use App\Models\Query;
use View;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

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
        View::composer('admin.layout.header', function($view)   // '*' means can we use anywhere if we mention route like web.layout.header then can we use only on header
        {
            if (Auth::guard('admin')->check()){
            $image = Admin::select('image')->where('id',Auth::guard('admin')->id())->first();
            $view->with('admin_image', $image);
        }
        });

        View::composer('*', function($view)   // '*' means can we use anywhere if we mention route like web.layout.header then can we use only on header
        {
            if (Auth::guard('admin')->check()){
            $queryCount = Query::where('type','chat')->count();
            $view->with('query_count', $queryCount);
            }
        });
    }
}
