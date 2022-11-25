<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\Models\User;
use App\Model\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('all-access', function(User $user){
            if($user->role_id == 1 || $user->role_id == 3){
                return true;
            }

        });

        Gate::define('register-access', function(User $user){
            if($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3){
                return true;
            }

        });

        Gate::define('edit-access', function(User $user){

            if($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3){
                return true;
            }
            else{

                return response()->json(['error' => 'UnAuthorised Access'], 401);
            }
            
        });



        Passport::routes();
    }
}
