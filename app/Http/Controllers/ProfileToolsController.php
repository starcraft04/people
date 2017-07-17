<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class ProfileToolsController extends Controller
{
	public function __construct()
	{

	}
	
	public function ajax_git_pull()
	{
		if (Auth::user()->name == 'admin'){
			$output = shell_exec('git -C /var/www/html pull');
			echo $output;
		}
	}

	public function ajax_env_app_debug($bool)
	{
		if (Auth::user()->name == 'admin'){
			if ($bool == 'true') {
				$this->setEnvironmentValue('APP_DEBUG', 'true');
			} elseif ($bool == 'false') {
				$this->setEnvironmentValue('APP_DEBUG', 'false');
			}
		}
	}

	protected function setEnvironmentValue($key, $newValue, $delim='')
	{
		$path = base_path('.env');
		// get old value from current env
		// but we need to treat the special case for APP_DEBUG returning 1 for true and nothing for false
		if ($key == 'APP_DEBUG') {
			if (env($key) == 1) {
			$oldValue = 'true';
			} else{
			$oldValue = 'false';
			}
		} else {
			$oldValue = env($key);
		}

		// was there any change?
		if ($oldValue === $newValue) {
			return;
		}

		// rewrite file content with changed data
		if (file_exists($path)) {
			// replace current value with new value
			file_put_contents(
				$path, str_replace(
					$key.'='.$delim.$oldValue.$delim,
					$key.'='.$delim.$newValue.$delim,
					file_get_contents($path)
				)
			);
		}

		// Reload the cached config
		if (file_exists(\App::getCachedConfigPath())) {
			Artisan::call("config:cache");
		}
	}
}
