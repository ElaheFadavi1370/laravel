<?php

namespace App\Providers;

use App\Answer;
use App\Policies\AnswerPolicy;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        \Gate::define('updated-question', function ($user , $question){
          return $user->id == $question->user_id;
        });
        \Gate::define('deleted-question', function ($user , $question) {
              return $user->id == $question->user_id;
          });
        \Gate::define('accept', function ($user , $question){
            return $user->id == $question->user_id;
        });
    }
}
