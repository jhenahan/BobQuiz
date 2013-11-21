<?php

include ".env.php";
include "functions.php";

try
{
    $db = checkedConnection( $dbEngine, $dbHost, $dbDatabase, $dbUsername,
                             $dbPassword );
}
catch ( PDOException $e )
{
    print "Error: " . $e->getMessage();
}
