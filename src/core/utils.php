<?php

namespace Core;

class Utils{

	/**
     * Print and die a value - Used for debugging.
     *
     * @param mixed $value Any PHP value.
     * @return void
     */
    public static function pd($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        wp_die();
    }

    /**
     * Print a value.
     *
     * @param mixed $value Any PHP value
     * @return void
     */
    public static function p($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }

    /**
     * Try get value by key from array
     * 	
     * @param  array $array 
     * @param type $key 
     * @param type $default default value
     * @return mixed value by key
     */
    public static function array_get($array, $key, $default = '')
    {
        $array = (array) $array;
    	if (is_null($key)) return $array;
    	if (array_key_exists($key, $array)) return $array[$key];
    	return $default;
    }

    /**
     * Join array to string
     * @param  array  $arr --- array like 'key' => 'value'
     * @return string --- joined string
     */
    public static function array_join($arr = array())
    {
        $arr    = self::array_remove_empty($arr);
        $result = array();
        foreach ($arr as $key => $value) 
        {
            $result[] = sprintf('%s="%s"', $key, $value);
        }
        return implode(' ', $result);
    }

    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function array_except($array, $keys)
    {
        return array_diff_key($array, array_flip((array) $keys));
    }

    /**
     * Remove empty elements
     * @param  array $arr --- array with empty elements
     * @return array --- array without empty elements
     */
    public static function array_remove_empty($arr)
    {
        return array_filter($arr, function($var) { return $var != ''; });
    }

    /**
     * Lave just right keys in array
     * 
     * @param  array $right_keys 
     * @param  array $array      
     * @return array             
     */
    public static function array_leave_right_keys($right_keys, $array)
    {
        $right_keys = (array) $right_keys;
        $array      = (array) $array;
        
        if(count($array))
        {
            foreach ($array as $key => $value) 
            {
                if(!in_array($key, $right_keys)) unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param type $haystack
     * @param type|array $needles
     * @return bool
     */
    public static function starts_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle)
        {
            if ($needle != '' && strpos($haystack, $needle) === 0) return true;
        }

        return false;
    }

    /**
     * Get string from echo buffer and return in variable
     * 
     * @param  mixed $func function name
     * @return string 
     */
    public static function echoToVar($func)
    {
        $result = '';
        if(is_callable($func))
        {
            ob_start();
            $func();
            $result = ob_get_clean();
        }
        return $result;
    }

    /**
     * Make template name from function arguments
     * 
     * @return string template name
     */
    public static function makeTemplateName()
    {
        $arguments = func_get_args();
        $sanitized = array();
        if(count($arguments))
        {
            foreach ($arguments as $argument) 
            {
                array_push($sanitized, (string) $argument);
            }
            $sanitized = self::array_remove_empty($sanitized);
        }
        return implode('-', $sanitized);
    }

    /**
     * Models path
     *
     * @return  string
     */
    public static function models_path()
    {
        return sprintf(
            '%s/app/models/',
            get_template_directory()
        );
    }

    /**
     * Widgets path
     * 
     * @return string
     */
    public static function widgets_path()
    {
        return sprintf(
            '%s/app/modules/widgets/',
            get_template_directory()
        );
    }

    /**
     * Pages path
     * 
     * @return string
     */
    public static function pages_path()
    {
        return sprintf(
            '%s/app/modules/pages/',
            get_template_directory()
        );
    }

    /**
     * Assets URL
     * 
     * @return string 
     */
    public static function assets_url()
    {
        return sprintf(
            '%s/app/assets/',
            get_template_directory_uri()
        );
    }

    /**
     * Instead $GLOBALS['wp_filesystem']->get_contents( $file )
     * @param type $url
     * @return string requres data
     */
    public static function get_contents($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}