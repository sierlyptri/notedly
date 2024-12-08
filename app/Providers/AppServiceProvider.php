<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// tambahkan ini untuk nanti jumlah string 
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //default jumlah string saat bikin tabel di migrasi, kalo ga salah max string tuh 255 tapi kita set 191
        Schema::defaultStringLength(191);
    }
}
