<?php

include('dbInfos.php');

    try
    {
        $dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', $user, $password);

        foreach($dbh->query('SELECT * from inboxTest') as $row)
        {
            print_r($row);
        }
        $dbh = null;
    }
    catch (PDOException $e)
    {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
