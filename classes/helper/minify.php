<?php
class Helper_Minify
{
	/**
	 * 
	 * Minify javascript files
	 * @param array $javascripts
	 * @param Cache $cache_instance
	 */
	public static function minify_js($javascripts = array(), Cache $cache_instance = NULL)
	{
		$output = '';
		if(count($javascripts) > 0 )
		{
			foreach(Minify::factory('js')->minify($javascripts) as $javascript)
			{
				if(is_object($cache_instance))
				{
					if($cache_instance->get($javascript))
					{
						$output .= '<script type="text/javascript">'.$cache_instance->get($javascript).'</script>';
					}
					else
					{
						$cache_instance->set($javascript, file_get_contents($javascript));
						$output .= '<script type="text/javascript" src="/'.$javascript.'"></script>';
					}
				}
				else
				{
					$output .= '<script type="text/javascript" src="/'.$javascript.'"></script>';
				}
			}
		}
		return $output;
	}
	
	/**
	 * 
	 * Minify css files
	 * @param array $stylesheets
	 * @param str $media
	 */
	public static function minify_css($stylesheets = array(), $media = 'screen')
	{
		$output = '';
		if(count($stylesheets) > 0 )
		{
			foreach(Minify::factory('css')->minify($stylesheets) as $stylesheet)
			{
				$output .= '<link rel="stylesheet" type="text/css" media="'.$media.'" rel="stylesheet" href="/'.$stylesheet.'" >';
			}
		}
		return $output;
	}
}