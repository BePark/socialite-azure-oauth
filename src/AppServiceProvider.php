<?php

namespace Bepark\SocialiteAzureOAuth;

use Illuminate\Routing\Router;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/socialite-azure-oauth.php' => config_path('socialite-azure-oauth.php'),
        ]);

	    foreach(config('socialite-azure-oauth', []) as $name => $instance)
	    {
			    app(\Laravel\Socialite\Contracts\Factory::class)->extend($name, function ($app) use ($name, $instance) {
				    return app(\Laravel\Socialite\Contracts\Factory::class)->buildProvider(
					    $instance['provider'],
					    $instance['credentials']
				    );
			    });

			    app('router')->group(['middleware' => $instance['routes']['middleware']], function(Router $router)  use ($name, $instance)
			    {
				    throw_if(is_null($instance['auth_controller']), new \Exception('Controller config need to be set for azure driver ' . $name));

				    $router->get($instance['routes']['login'], $instance['auth_controller'] . '@redirectToOauthProvider')->name('sso.' . $name . '.get_login');
				    $router->get($instance['routes']['callback'], $instance['auth_controller'] . '@handleOauthResponse')->name('sso.' . $name . '.get_callback');
			    });
		    }
    }
}
