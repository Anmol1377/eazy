<?php
/**
 *       @file  ezyStats.php
 *      @brief  This module contains investigation statistics
 *
 *     @author  ezy_sc (ezy), contact@bikswee.com
 *
 *   @internal
 *    Compiler  gcc/g++
 *     Company  EaZy Security by Bikswee
 *   Copyright  Copyright (c) 2023, ezy_sc
 *
 * =====================================================================================
 */

define( 'ezy_STATS','ezy_sc_wp_stats');

require_once('ezyOptions.php');

class CezyStats
{
    protected $_stats;

    public function __construct()
    {
        $this->_stats = array();
        $this->_LoadStats();
    }

    public function Reset()
    {
        $this->_stats = array();
        $this->_stats["TOTAL"]          = 0;
        $this->_stats["CLEAN"]          = 0;
        $this->_stats["SUSPICIOUS"]     = 0;
        $this->_stats["POT_SUSPICIOUS"] = 0;
        $this->_stats["MALICIOUS"]      = 0;
        $this->_stats["START_TIME"]     = time();
        $this->_StoreStats();
        return TRUE;
    }


    public function Get()
    {
        $this->_LoadStats();
        return $this->_stats;
    }


    public function IncTotal()
    {
        return $this->_Inc("TOTAL");
    }


    public function IncClean()
    {
        $this->IncTotal();
        return $this->_Inc("CLEAN");
    }

    public function IncSusp()
    {
        $this->IncTotal();
        return $this->_Inc("SUSPICIOUS");
    }

    public function IncPotSusp()
    {
        $this->IncTotal();
        return $this->_Inc("POT_SUSPICIOUS");
    }

    public function IncMalicious()
    {
        $this->IncTotal();
        return $this->_Inc("MALICIOUS");
    }

    public function Increment($severity){

        $sev = strtolower($severity);

        if(strpos($sev,"malicious") !== FALSE )
        {
            return $this->IncMalicious();
        }        
        else if(strpos($sev,"pot") !== FALSE )
        {
            return $this->IncPotSusp();
        }
        else if(strpos($sev,"susp") !== FALSE )
        {
            return $this->IncSusp();
        }
        return $this->IncClean();
    }

    public function Total($v=NULL){
        if( is_int($v) ){
            $this->_stats["TOTAL"] = $v;
        }
        return $this->_stats["TOTAL"];
    }

    public function Clean($v=NULL){
        if( is_int($v) ){
            $this->_stats["CLEAN"] = $v;
        }
        return $this->_stats["CLEAN"];
    }

    public function Suspicious($v=NULL){
        if( is_int($v) ){
            $this->_stats["SUSPICIOUS"] = $v;
        }
        return $this->_stats["SUSPICIOUS"];
    }

    public function PotSuspicious($v=NULL){
        if( is_int($v) ){
            $this->_stats["POT_SUSPICIOUS"] = $v;
        } 
        return $this->_stats["POT_SUSPICIOUS"];
    }

    public function Malicious($v=NULL){
        if( is_int($v) ){
            $this->_stats["MALICIOUS"] = $v;
        }
        return $this->_stats["MALICIOUS"];
    }

    public function StartTime(){
        return $this->_stats["START_TIME"];
    }

    public function GetCounters(){
        return $this->_stats;
    }

    /******************************************************
     *
     *      PROTECTED METHODS 
     *
     *****************************************************/
    protected function _LoadStats(){
        $body   = CezyOptions::GetOption ( ezy_STATS );
        if( $body ){
            $this->_stats = CezyOptions::Unserialize( $body );
            if( !is_array( $this->_stats ) ){
                /* 
                 * something gone wrong, reset statistics
                 */
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

    protected function _StoreStats(){
        $body = CezyOptions::Serialize( $this->_stats );

        if ( CezyOptions::GetOption( ezy_STATS ) !== false ) 
        {
            $rc = CezyOptions::UpdateOption( ezy_STATS , $body );
            return $rc;
        }
        else 
        {
            $deprecated = null;
            $autoload = 'no';
            return CezyOptions::AddOption( ezy_STATS , $body ,$deprecated, $autoload );
        }
    }   


    protected function _Inc($name)
    {
        if( isset($this->_stats[$name]) )
        {
            $this->_stats[$name] = intval($this->_stats[$name]) + 1;
        }
        else
        {
            $this->_stats[$name] = 1;
        }

        $this->_StoreStats();
        return $this->_stats[$name];
    }
}

?>
