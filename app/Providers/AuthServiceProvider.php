<?php

namespace App\Providers;

use App\Models\Survey;
use App\Policies\SurveyPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->policies;
    }

    protected $policies = [
        Survey::class => SurveyPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->register();
    }
}
