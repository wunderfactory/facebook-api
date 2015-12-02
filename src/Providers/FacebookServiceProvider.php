<?php

namespace Wunderfactory\Facebook\Providers;

use Illuminate\Support\ServiceProvider;
use Wunderfactory\Facebook\Facebook;

class FacebookServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('facebook', function()
		{
			return new Facebook();
		});
	}
}