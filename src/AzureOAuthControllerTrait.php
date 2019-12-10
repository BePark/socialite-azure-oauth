<?php

namespace Bepark\SocialiteAzureOAuth;

use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User;

trait AzureOAuthControllerTrait
{
	/** @var string */
	protected $_driver = 'azure-oauth-login';

	/**
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
    public function redirectToOauthProvider()
    {
        return Socialite::driver($this->_driver)->redirect();
    }

	/**
	 * @throws \Exception
	 */
    public function handleOauthResponse()
    {
        $user = Socialite::driver($this->_driver)->user();

        return $this->handleOAuthUser($user);
    }

	/**
	 * @param User $user
	 * @throws \Exception
	 */
    protected function handleOAuthUser(User $user) {
    	throw new \Exception('Method ' . __METHOD__ . ' is not implemented');
    }

    protected function setDriver(string $driverName)
	{
		if(is_array(config('socialite-azure-oauth.' . $driverName)))
		{
			$this->_driver = $driverName;
		}

		throw new \Exception('Driver ' . $driverName . ' is not configured in your config file.');

	}

	protected function getDriver(): string
	{
		return $this->_driver;
	}
}
