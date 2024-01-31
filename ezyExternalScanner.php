<?php
/**
 *       @file  ezyExternalScanner.php
 *      @brief  This module contains API to query external scanner
 *
 *     @author  ezy_sc (ezy), contact@bikswee.com
 *
 *   @internal
 *    Compiler  gcc/g++
 *     Company  EaZy_Security 
 *   Copyright  Copyright (c) 2023, ezy_sc
 *
 * =====================================================================================
 */


class CezyExternalScanner
{

    /**
    * @brief       sends request to remote scanner 
    * @param[in]   remote_url - URL query 
    * @return      on success returns retireved Json, on failure empty string
    */
    public static function SendQuery ( $remote_url )
    {
        if( function_exists('curl_init') )
        {
        /* curl library loaded */ 
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $remote_url );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $data = curl_exec($curl);
            curl_close($curl);
            return $data;
        }else{
            return file_get_contents( $remote_url );
        }
    }

}


?>
