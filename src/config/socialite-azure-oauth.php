<?php

return [
	'azure-oauth-login' => [
		'auto-load' => true,//define if this need to ne loaded on app boot. If false, you'll have to load it by yourself.
		'routes' => [
			// The middleware to wrap the auth routes in.
			// Must contain session handling otherwise login will fail.
			'middleware' => 'web',

			// The url that will redirect to the SSO URL.
			// There should be no reason to override this.
			'login' => 'login/microsoft',// route name = sso.azure-oauth-login.get_login, azure-oauth-login is the name of the driver (key of this array)

			// The app route that SSO will redirect to.
			// There should be no reason to override this.
			'callback' => 'login/microsoft/callback',// route name =sso.azure-oauth-login.get_callback
		],
		'credentials' => [
			'client_id' => env('AZURE_AD_CLIENT_ID', ''),
			'client_secret' => env('AZURE_AD_CLIENT_SECRET', ''),
			'redirect' => env('APP_URL') . '/login/microsoft/callback'
		],

		//Enter here your own AuthController if you want to override the package controller.
		'auth_controller' => null,

		//provider used to generate the socialite driver. This can be overrided if you need to extends it.
		'provider' => \Bepark\SocialiteAzureOAuth\AzureOauthProvider::class,
	],
];
