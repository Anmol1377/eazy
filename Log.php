<?php

require_once('ezyLogger.php');

$logger = new CezyLogger();
$lines = $logger->GetAllLines();

foreach($lines as $line){
    printf("%s %s\n",$line[1],$line[2]);
}

?>
