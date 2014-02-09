<?php

require_once ".env.php";
require_once "functions.php";

try
{
    $db = checkedConnection( $dbEngine, $dbHost, $dbDatabase, $dbUsername,
                             $dbPassword );
}
catch ( PDOException $e )
{
    print "Error: " . $e->getMessage();
}
