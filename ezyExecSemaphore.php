<?php
/**
 *       @file  ezyExecSemaphore.php
 *      @brief  This module contain promitive mechanism to control execution of scanner
 *
 *     @author  EaZy Security (ezy), contact@bikswee.com
 *
 *   @internal
 *    Compiler  gcc/g++
 *     Company  EaZy Security
 *   Copyright  Copyright (c) 2023, EaZy Security
 * =====================================================================================
 */

define( 'ezy_EXEC_SEM','ezy_sc_wp_exec_sem');

require_once('ezyOptions.php');

class CezyExecSem
{
    protected $_status;

    public function __construct()
    {
        $this->_status = array();
        $this->_LoadStatus();
    }

    public function Reset(){    
        $this->_status = array();
        $this->_status["SCANNER_PID"] = 0;
        $this->_status["STARTED_BY"]  = NULL;
        $this->_status["SHOULD_STOP"] = 0;
        $this->_status["LAST_UPDATE"] = time();
        $this->_status["START_TIME"]  = 0;
        $this->_StoreStatus();
        return TRUE;
    }

    public function Get(){
        $this->_LoadStatus();
        return $this->_status;
    }

    public function ScannerPid($pid){
        $this->_LoadStatus();
        $this->_status["SCANNER_PID"] = $pid;
        $this->_StoreStatus();
    }

    public function ShouldStop( $flag = NULL ){
        $this->_LoadStatus();
        if( $flag === NULL ){
            return $this->_status["SHOULD_STOP"];
        }else{
            $this->_status["SHOULD_STOP"] = $flag;

            if( $flag == "RUN" ){
                $this->_status["START_TIME"] = time();
            }else if( $flag == "DONE"){
                $this->_status["START_TIME"] = 0;
            }

            $this->_StoreStatus();
            return $this->_status["SHOULD_STOP"];
        }
    }

    public function StartTime(){
        $this->_LoadStatus();
        return $this->_status["START_TIME"];
    }

    public function LastUpdate(){
        $this->_LoadStatus();
        return $this->_status["LAST_UPDATE"];
    }

    public function StartedBy($module = NULL ){
        $this->_LoadStatus();
        if( $module === NULL ){
            return $this->_status["STARTED_BY"];
        }
        $this->_status["STARTED_BY"] = $module;
        $this->_StoreStatus();
        return $this->_status["STARTED_BY"];
    }

    /******************************************************
     *
     *      PROTECTED METHODS 
     *
     *****************************************************/
    protected function _LoadStatus()
    {
        $body   = CezyOptions::GetOption( ezy_EXEC_SEM );

        if( $body )
        {
            $this->_status = CezyOptions::Unserialize( $body );

            if( !is_array( $this->_status ) ){
                /* 
                 * something gone wrong, reset
                 */
                //echo "RESET\n";
                $this->Reset();
            }
        }else{
            /*
             * nothing found
             */
            $this->Reset();
        }

        return TRUE;
    }

    protected function _StoreStatus()
    {

        $this->_status["LAST_UPDATE"] = time();

        $body = CezyOptions::Serialize( $this->_status );

        // echo "Store: " . $body . "\n";

        if ( CezyOptions::GetOption( ezy_EXEC_SEM, false ) !== false ) 
        {
            $rc = CezyOptions::UpdateOption( ezy_EXEC_SEM , $body );
            return $rc;
        }
        else 
        {
            $deprecated = null;
            $autoload = 'no';
            return CezyOptions::AddOption( ezy_EXEC_SEM , $body ,$deprecated, $autoload );
        }
    }   
}

?>
