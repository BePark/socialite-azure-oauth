# Laravel Socialite Azure Active Directory Plugin

Inspired by metrogistics/laravel-azure-ad-oauth and updated to allow multi azure connection and better override.

## Installation

Publish the config and override any defaults:

```
php artisan vendor:publish
```

Add the necessary env vars following what defined in your config file. By default :

```
AZURE_AD_CLIENT_ID=XXXX
AZURE_AD_CLIENT_SECRET=XXXX
```

## Usage

Create a controller and import the trait AzureOAuthControllerTrait. It'll provide you method for socialite oAuth.
Then add your controller namespace in config file for key `auth_controller`

After the setup of your Azure AD (see below), all you need to do to make use of Azure AD SSO is to point a user to the `/login/microsoft` route (configurable) for login. 

Once logged, user will be redirected and will trigger the method `handleOAuthUser()` of your own controller.

## Azure AD Setup

1. Navigate to `Azure Active Directory` -> `App registrations`.
2. Create a new application
  1. Choose a name
  2. Select the wanted value for supported account types (it's up to you)
  2. On platform configuration, select "Client Application (Web, iOS, Android, Desktop+Devices)"
  4. Click "Create"
3. Click into the newly created app.
4. The "Application ID" is what you will need for your `AZURE_AD_CLIENT_ID` env variable.
5. Click into "Redirect URIs". You will need to whitelist the redirection path for your app here. It will typically be `https://domain.com/login/microsoft/callback`. Click "Save"
6. Select the permissions required for you app in the "Api permissions" tab.
7. Add any necessary roles to the manifest:
  1. Click on the "Manifest" tab.
  2. Add roles as necessary using the following format:

		```
		"appRoles": [
		    {
		      "allowedMemberTypes": [
		        "User"
		      ],
		      "displayName": "Manager Role",
		      "id": "08b0e9e3-8d88-4d99-b630-b9642a70f51e",// Any unique GUID
		      "isEnabled": true,
		      "description": "Manage stuff with this role",
		      "value": "manager"
		    }
		  ],
		```
  3. Click "Save"
8. In the "Certificates & secrets" tab, click on "new client secret" enter a description (something like "App Secret"). Set Duration to "Never Expires". Click "Save". Copy the whole key. This will not show again. You will need this value for the `AZURE_AD_CLIENT_SECRET` env variable.
9. Go back in Azure active directory and click on the "Entreprise application" link. Then click on the application name
10. Under the "Properties" tab, enable user sign-in. Make user assignment required. Click "Save".
11. Under the "Users and groups" tab, add users and their roles as needed.
12. Extra: configure published domain to make your app verified : https://docs.microsoft.com/fr-be/azure/active-directory/develop/howto-configure-publisher-domain#configure-publisher-domain-using-the-azure-portal
