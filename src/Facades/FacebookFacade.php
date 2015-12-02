<?php

namespace Wunderfactory\Facebook\Facades;

use Illuminate\Support\Facades\Facade;

class FacebookFacade extends Facade {

	protected static function getFacadeAccessor() { return 'facebook'; }
}