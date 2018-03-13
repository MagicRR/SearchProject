<?php

include('dbInfos.php');

    try
    {
        $dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', $user, $password);
    }
    catch (PDOException $e)
    {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
