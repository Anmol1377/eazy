#!/usr/bin/php

<?php

error_reporting(E_ALL);

define( 'ABSPATH', dirname(__FILE__) . '/' );

require_once('ezyFilesScanner.php');
require_once('ezyLogger.php');
    
    $path = getcwd();
    $logger = new CezyLogger();
    $logger->Clean();
    
    if( count( $argv ) >= 2 )     
    {
        echo "Input scan path: " . $argv[1] . "\n";

        if( is_file($argv[1]) or is_dir($argv[1]) )
        {
            echo "Setting scan path " . $argv[1] . "\n";
            $path = $argv[1];
        }
        else
        {
            echo "$argv[1] is not a file or dir\n";
        }
    }

    printf("Starting scan of %s\n",$path);

    $scanner = new CezyFilesScanner(TRUE/*heuristic*/);

    $scanner->Initialize();

    $exec_sem = new CezyExecSem();

    printf("Update execution status to RUN\n");

    $exec_sem->ShouldStop('RUN');

    echo "Execution state: " . $exec_sem->ShouldStop() . "\n";

    $exec_sem->StartedBy('TESTER');

    echo "StartedBy:  " .  $exec_sem->StartedBy() . "\n";

    $lock = new CezyScanLock();

    $rc = $lock->Acquire();

    if( !$rc ){
        echo "Failed to acquire scan lock\n";
        die();
    }

    if( !$lock->IsLocked() ){
        echo "Failed to verify lock existence\n";
        die();
    }

    $scanner->Scan($path);

    /*
    $rc = $lock->Release();
    if( !$rc ){
        echo "Failed to release lock\n";
    }*/

    $scanner->Finalize();

    printf("Scan of %s is done.\n",$path);

?>