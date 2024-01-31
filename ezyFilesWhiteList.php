<?php
/**
 *       @file  ezyFilesWhiteList.php
 *      @brief  This module contains implementation of a list white-listed files
 *
 *     @author  EaZy Security (ezy), contact@bikswee.com
 *
 *   @internal
 *    Compiler  gcc/g++
 *     Company  EaZy Security by Bikswee
 * 
 *   Copyright  Copyright (c) 2023, EaZy Security
 *
 * =====================================================================================
 */

require_once('ezyOptions.php');
require_once('ezyConfig.php');
require_once('ezyLogger.php');

define( 'ezy_FILES_WHITE_LIST','ezy_sc_wp_files_white_list');
define( 'ezy_FILES_WL_FILE','ezy_files.wl');
define( 'ezy_IGNORE_FILE', 'ezy.ignore');

class CezyFilesWhiteList
{
    protected   $_list = NULL;
    protected   $_ignore_list = NULL;   // ignore list added to handle #824163
    protected   $_type = ezy_FILES_WHITE_LIST;
    protected   $_logger;

    public function __construct( ){
        $this->_logger = new CezyLogger();
    }

    public function Load(){
        $this->_list = array();
        $this->_ignore_list = array();
        $this->_LoadFromDb();
        $this->_LoadFromFile();
        $this->_LoadIgnoreList();
        return TRUE;
    }

    public function IsLoaded(){
        if( $this->_list != NULL and count($this->_list) > 0 ){
            return TRUE;
        }

        return FALSE;
    }

    public function IsIgnored( $path )
    {
        /* check if given path file or directory should be skipped */
        if(!defined("ezy_USE_IGNORE_LIST"))
        {
            return FALSE;
        }

        foreach($this->_ignore_list as $ignore_path )
        {
            // path points to file or directory to check
            // ignore_path is the rule from ignore file
            $pos = strpos($path, $ignore_path);
            if( $pos !== FALSE )
            {
                // ignore_path found in the path
                $this->_logger->Info(sprintf("Skipping %s due to ignore rule %s, rule found at offset $pos", $path, $ignore_path ));
                return TRUE;
            }
        }
        //nothing found
        return FALSE;
    }

    public function IsWhiteListedFile( $path ){
        if( !is_file($path)){
            $this->_logger->Error("$path is not a file\n");
            return FALSE;
        }

        $md5 = md5_file($path);
        return $this->IsWhiteListed( $md5 );
    }

    public function IsWhiteListed( $md5 ){
        //$this->_logger->Info("Test if $md5 is whitelisted");
        $lowwer = strtolower($md5);
        $upper  = strtoupper($md5);

        if( isset( $this->_list[$lowwer] ) )
        {
            //$this->_logger->Info("$md5 is whitelisted");
            return TRUE;
        }

        if( isset( $this->_list[$upper] ) )
        {
            //$this->_logger->Info("$md5 is whitelisted");
            return TRUE;
        }

        return FALSE;
    }

    public function Clean(){
        $body = CezyOptions::Serialize( array() );
        if ( CezyOptions::GetOption( ezy_FILES_WHITE_LIST ) !== false ){
            CezyOptions::UpdateOption(  ezy_FILES_WHITE_LIST , $body );
        } else {
            $deprecated = null;
            $autoload   = 'no';
            CezyOptions::AddOption( ezy_FILES_WHITE_LIST , $body ,$deprecated, $autoload );
        }

        $this->Load();
        return TRUE;
    }

    public function AddByPath( $path ){
        if( !is_file($path)){
            return FALSE;
        }
        $md5 = md5_file( $path );
        return $this->AddBySig( $md5 );
    }


    public function AddBySig( $sig ){
        /*
         * reload cache to test entire picture
         */
        $this->Load();

        if( isset($this->_list[$sig]) ){
            /*
             * File already whitelisted
             */
            return FALSE;
        }

        $this->_list[$sig]  = "clean";
        
        /*
         * Store into DB
         */
        $list = array();
        $body   = CezyOptions::GetOption( ezy_FILES_WHITE_LIST );
        if( $body ){
            $list = CezyOptions::Unserialize( $body );
            if( !is_array( $list ) ){
                /* 
                 * something gone wrong, reset report
                 */
                $list = array();
            }
        }

        $list[$sig]         = "clean";
        /*
         * add to DB only changable list
         */
        $body = CezyOptions::Serialize( $list );
        if ( CezyOptions::GetOption( ezy_FILES_WHITE_LIST ) !== false ){
            return CezyOptions::UpdateOption(  ezy_FILES_WHITE_LIST , $body );
        } else {
            $deprecated = null;
            $autoload   = 'no';
            return CezyOptions::AddOption( ezy_FILES_WHITE_LIST , $body ,$deprecated, $autoload );
        }
        return TRUE;
    }


    public function RemoveByPath( $path ){
        if(!is_file( $path ) ){
            return FALSE;
        }

        $md5 = md5_file($path);
        return $this->RemoveBySig( $md5 );
    }

    public function RemoveBySig( $sig ){
        /*
         * cleanup is possible only from data managed in database
         */
        $list = array();
        $body   = CezyOptions::GetOption( ezy_FILES_WHITE_LIST );
        if( $body ){
            $list = CezyOptions::Unserialize( $body );
            if( !is_array( $list ) ){
                /* 
                 * something gone wrong, reset report
                 */
                return FALSE;
            }
        }else{
            return FALSE;
        }

        if( !isset( $list[$md5] ) ){
            return FALSE;
        }

        unset( $list[$md5] );

        $body = CezyOptions::Serialize( $list );

        if ( CezyOptions::GetOption( ezy_FILES_WHITE_LIST ) !== false ){
            CezyOptions::UpdateOption(  ezy_FILES_WHITE_LIST , $body );
        } else {
            $deprecated = null;
            $autoload   = 'no';
            CezyOptions::AddOption( ezy_FILES_WHITE_LIST , $body ,$deprecated, $autoload );
        }
        /*
         * reload internal cache
         */
        return $this->Load();
    }

    /****************************************
     *      PROTECTED METHODS
     ***************************************/
    protected function _LoadFromDb(){
        $body   = CezyOptions::GetOption( ezy_FILES_WHITE_LIST );
        if( $body ){
            $list = CezyOptions::Unserialize( $body );
            if( !is_array( $list ) ){
                /* 
                 * something gone wrong, reset report
                 */
                return FALSE;
            } else {
                $this->_list = array_merge( $this->_list, $list );
            }
        }else{
            /*
             * Nothing found in DB
             */
            return FALSE;
        }
    }


    protected function _LoadFromFile()
    {
        $wl_file = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . ezy_FILES_WL_FILE;

        if( !is_file( $wl_file ) )
        {
            $this->_logger->Error("Failed to locate WL file " . $wl_file );
            return FALSE;
        }

        //$this->_logger->Info(ezy_FILES_WL_FILE . " located successfully. Loading list of whitelisted files");

        $fd = fopen( $wl_file , "r" );

        if( !$fd )
        {
            $this->_logger->Error("Failed to open " . $wl_file );
            return FALSE;
        }

        $list = array();
        while( ($line = fgets($fd)) !== FALSE ){
            $line = trim($line);
            if( strlen($line) > 0 && $line[0] != '#' ){
                $this->_list[$line] = "clean";
            }
        }

        fclose( $fd );
        //$this->_logger->Info( sprintf("%d files loaded from %s", count($this->_list), $wl_file ) );
        return TRUE;
    }

    protected function _LoadIgnoreList()
    {
        if(!defined("ezy_USE_IGNORE_LIST"))
        {
            #$this->_logger->Info("Ignore list support is not defined");
            return FALSE;
        }

        $ignore_file = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . ezy_IGNORE_FILE;

        if( !is_file( $ignore_file ) )
        {
            $this->_logger->Error("Failed to locate ignore-list file " . $ignore_file );
            return FALSE;
        }

        //$this->_logger->Info(ezy_FILES_WL_FILE . " located successfully. Loading list of whitelisted files");

        $fd = fopen( $ignore_file , "r" );

        if( !$fd )
        {
            $this->_logger->Error("Failed to open " . $ignore_file);
            return FALSE;
        }

        $list = array();
        while( ($line = fgets($fd)) !== FALSE ){
            $line = trim($line);
            if( strlen($line) > 0 && $line[0] != '#' ){
                array_push($this->_ignore_list, $line);
            }
        }

        fclose( $fd );
        //$this->_logger->Info( sprintf("%d files loaded from %s", count($this->_list), $wl_file ) );
        return TRUE;

    }
}

?>
