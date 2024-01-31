<?php

/**
 *       @file  ezyLogger.php
 *      @brief  plugin logger implementation
 *
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

require_once('ezyConfig.php');
require_once('ezyOptions.php');

define( 'ezy_LOGGER','ezy_sc_wp_logger');

class CezyLogger
{
    protected $_log_cache;
    protected $_severity;    
    protected $_config;
    protected $_max_lines;
    protected $_is_cli;
    protected $_log_file;
    protected $_log_file_name;

    public function __construct()
    {
        $this->_config      = new CezyConfig();
        $this->_severity    = $this->_config->LogSeverity();
        $this->_max_lines   = 20;

        if (php_sapi_name() == "cli") { 
            $this->_is_cli = TRUE;
        } else {
            $this->_is_cli = FALSE;
        }

        $this->_log_file_name =  dirname(__FILE__) . DIRECTORY_SEPARATOR . 'runtime.log';

        $this->_LoadLog();

        $this->_OpenLogFile();
    }

    public function Severity(){
        return $this->_severity;
    }

    public function SeverityStr(){
        return $this->_config->LogSeverityStr( $this->_severity);
    }


    public function Clean(){
        /*
         * reset log lines stored in database
         */
        $this->_log_cache = array();
        $this->_StoreLog();
        /*
         * reset log file
         */
        $this->_ResetLog();
    }


    public function Info( $msg ){
        if( $this->_severity >= CezyConfig::$LOG_SEVERITY["INFO"] ){
            $this->_Trim();
            $this->_Log("INFO",$msg);
        }
    }

    public function Warning( $msg ){
        if( $this->_severity >= CezyConfig::$LOG_SEVERITY["WARNING"] ){
            $this->_Trim();
            $this->_Log("WARNING",$msg);
        }
    }

    public function Error( $msg ){
        if( $this->_severity >= CezyConfig::$LOG_SEVERITY["ERROR"] ){
            $this->_Trim();
            $this->_Log("ERROR",$msg);
        }
    }

    public function GetFromLine( $line = 0 ){
        $size   = count( $this->_log_cache );
        $index  = 0;
        for(;$index < $size;$index++){
            if( $this->_log_cache[$index][0] >= $line ){
                break;
            }
        }

        if( $index < $size ){
            $output = array();
            for(;$index < $size;$index++){
                array_push($output,$this->_log_cache[$index]);
            }
            return $output;
        }else{
            return NULL;
        }
    }

    public function GetAllLines(){
        return $this->_log_cache;
    }

    /***************************************************************
     *                  PROTECTED METHODS
     **************************************************************/
    protected function _Trim(){
        if( count( $this->_log_cache ) > $this->_max_lines ){
            while( count( $this->_log_cache ) > $this->_max_lines ){
                array_shift ( $this->_log_cache );
            }
        }
    }

    protected function _Log( $severity, $msg ){
        
        if ( $this->_is_cli ) {
            printf("[%s] %s %s\n",date("h:i:s"),$severity,$msg);
            $this->_WriteLog($severity, $msg);
            return;
        }

        /*
         * Write to log file if log file in use
         */
        $this->_WriteLog($severity, $msg);

        $this->_LoadLog();

        if( count($this->_log_cache ) == 0 ){
            /*
             * log cache empty, adding first line
             */
            array_push( $this->_log_cache, array(0,$severity,$msg));
        } else {
            $last = end($this->_log_cache);
            if( !$last ){
                /* 
                 * adding this log line as a first one 
                 */
                array_push( $this->_log_cache, array(0,$severity,$msg));
            } else {
                /*
                 * append new log line
                 */
                $index = $last[0] + 1;
                array_push( $this->_log_cache,array($index,$severity,$msg));
            }
        }

        $this->_StoreLog();
    }

    protected function _StoreLog()
    {
        $body = CezyOptions::Serialize( $this->_log_cache );

        if ( CezyOptions::GetOption( ezy_LOGGER ) !== false ) 
        {
            $rc = CezyOptions::UpdateOption( ezy_LOGGER, $body );
        }
        else 
        {
            $deprecated = null;
            $autoload = 'no';
            return CezyOptions::AddOption( ezy_LOGGER, $body ,$deprecated, $autoload );
        }
    }


    protected function _LoadLog()
    {
        $body   = CezyOptions::GetOption( ezy_LOGGER );
        if( $body )
        {
            $this->_log_cache = CezyOptions::Unserialize( $body );

            if( !is_array( $this->_log_cache ) ){
                /* 
                 * something gone wrong, reset log 
                 */
                $this->_log_cache = array();
            }

        }
        else
        {
            /*
             * nothing found
             */
            $this->_log_cache = array();
        }

        $this->_Trim();
        return TRUE;
    }

    protected function _OpenLogFile()
    {
        /*
         * open file and move pointer to the end of file
         */
        $this->_log_file = fopen( $this->_log_file_name, "a+");
        return $this->_log_file;
    }


    protected function _WriteLog( $severity, $msg )
    {
        if( $this->_log_file )
        {
            $rc = fwrite(   $this->_log_file,
                            sprintf("[%s] %s\t%s\n",
                                date("h:i:s"),
                                $severity,
                                $msg));

            fflush($this->_log_file);
            return $rc;
        }
        return 0;
    }

    protected function _ResetLog()
    {
        if( $this->_log_file ){
            fclose($this->_log_file);
            $this->_log_file = NULL;
        }
        /*
         * open file and erase all its content
         */
        @unlink($this->_log_file_name);
        $this->_log_file = fopen($this->_log_file_name, "w+");
        return $this->_log_file;
    }

}

?>
