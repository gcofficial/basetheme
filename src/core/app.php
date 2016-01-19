<?php

namespace Core;

class App{
	public static function start()
	{
		/**
		 * Loading all configurations
		 */
		\Configuration\Configuration::load();
	}
}