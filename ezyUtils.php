<?php
/**
 *       @file  ezyUtils.php
 *      @brief  This module contains utility and helper functions 
 *
 *     @author  ezy_sc (ezy), contact@bikswee.com
 *
 *   @internal
 *    Compiler  gcc/g++
 *     Company  ezy_sc
 *   Copyright  Copyright (c) 2023, ezy_sc
 *
 * =====================================================================================
 */

class CezyUtils
{
    public static function PluginRootDir()
    {
        return plugin_dir_url( __FILE__ );
    }


    public static function  GetDomainName()
    {
        $domain_name = network_site_url( '/' );
        $parse = parse_url($domain_name);
        return $parse['host']; // prints 'google.com'
    }


    public static function GetUrlContent($url)
    {
        if (function_exists('curl_init'))
        { 
            $conn = curl_init($url);
            curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
            curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
            $url_get_contents_data = curl_exec($conn);
            curl_close($conn);
        }
        elseif(function_exists('file_get_contents'))
        {
            $url_get_contents_data = file_get_contents($url);
        }
        elseif(function_exists('fopen') && function_exists('stream_get_contents'))
        {
            $handle = fopen ($url, "r");
            if($handle ==FALSE)
            {
                $url_get_contents_data = FALSE;
            }
            else
            {
            	$url_get_contents_data = stream_get_contents($handle);
            	fclose($handle);
	        }
        }
        else
        {
            $url_get_contents_data = false;
        }
        return $url_get_contents_data;
    } 
}

?>
