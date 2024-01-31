<?php
/**
 *       @file  ezyThreatsWhiteList
 *      @brief  This module contains implementation of a threats white list (threats whitelisted by user)
 *
 *     @author  ezy_sc (ezy), contact@bikswee.com
 *
 *   @internal
 *    Compiler  gcc/g++
 *     Company  EaZy Security By Bikswee
 *   Copyright  Copyright (c) 2023, ezy_sc
 *
 * =====================================================================================
 */


define( 'ezy_THREATS_WHITE_LIST','ezy_sc_wp_threats_white_list');

class CezyThreatsWhiteList
{
    protected $_type = ezy_THREATS_WHITE_LIST;

    public function __construct( $type = NULL )
    {
        $this->_config      = new CezyConfig();
        $this->_logger      = new CezyLogger();
        $this->_report      = array();
        if( $type != NULL ){
            $this->_type = $type;
        }else{
            $type = ezy_THREATS_WHITE_LIST;
        }

        $this->_LoadList();
    }

    public function Add($file_sig,$threat_sig)
    {
        $this->_LoadList();
        $key = $this->_BuildKey( $file_sig , $threat_sig );
        if(isset( $this->_report[$key]) ){
            return FALSE;
        }

        $this->_report[$key] = array( $file_sig, $threat_sig );
        $this->_StoreList();
        return TRUE;
    }

    public function GetList(){
        return $this->_report;
    }

    public function Get( $file_sig, $threat_sig )
    {
        $this->_LoadList();

        $key = $this->_BuildKey( $file_sig,$threat_sig);

        if( isset( $this->_report[$key] ) ){
            return $this->_report[$key];
        }

        return NULL;
    }

    public function Remove( $file_sig, $threat_sig )
    {
        $this->_LoadList();
        $key = $this->_BuildKey( $file_sig, $threat_sig );
        if( isset( $this->_report[$key] ) ){
            unset( $this->_report[$key] );
            $this->_StoreList();
        }
    
        return FALSE;
    }


    public function Clean( )
    {
        $this->_report = array();
        $this->_StoreList();
        return TRUE;
    }


    /***************************************************************************
     *
     *      PROTECTED METHODS
     *
     **************************************************************************/
    protected function _BuildKey( $file, $threat )
    {
        return $file . ":" . $threat;
    }

    protected function _LoadList()
    {
        $body   = CezyOptions::GetOption( $this->_type );

        if( $body )
        {
            $this->_report = CezyOptions::Unserialize( $body );

            if( !is_array( $this->_report ) ){
                /* 
                 * something gone wrong, reset report
                 */
                $this->_report = array();
            }
        }else{
            /*
             * nothing found
             */
            $this->_report = array();
        }

        return TRUE;
    }

    protected function _StoreList( )
    {

        $body = CezyOptions::Serialize( $this->_report );

        if ( CezyOptions::GetOption( $this->_type ) !== false ) 
        {
            $rc = CezyOptions::UpdateOption( $this->_type , $body );
        }
        else 
        {
            $deprecated = null;
            $autoload   = 'no';
            return CezyOptions::AddOption( $this->_type, $body ,$deprecated, $autoload );
        }
    }   

}


?>
