<?php

namespace App\Providers;

use App\Events;
use App\Events\UserEvent;
use App\Models\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @return void Register any application services.
     */
    public function register()
    {
    }

    /**
     * @return void Boot the authentication services for the application.
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain

        // the User instance via an API token or any other method necessary.
        $this->app['auth']->viaRequest('api', function ($request) {
            /** @var \Illuminate\Http\Request $request */
            $token = $request->header('X-API-TOKEN');
            if (null === $token) {
                return;
            }

            $user = User::where('api_token', $token)->first();
            $active = $user->active;

            if (true !== $active) {
                event(new UserEvent(
                    $user->id,
                    Events::USER_AUTHORIZATION_FAILED,
                    new \DateTime()
                ));

                throw new \Exception('User not active. No permit to use api.');
            }

            return $user;
        });
    }
}
