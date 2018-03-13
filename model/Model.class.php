<?php

$dbHost = 'mysql-instance1.cz1z81i5du0a.eu-west-1.rds.amazonaws.com';
$dbName = 'eurondb';
$user   = 'mysqladmin';
$password = "allanlevener77230";

class Model
{

    protected $oPDO     = false;

    function __construct()
    {
        $dbHost = 'mysql-instance1.cz1z81i5du0a.eu-west-1.rds.amazonaws.com';
        $dbName = 'eurondb';
        $user   = 'mysqladmin';
        $password = "allanlevener77230";

        try
        {
            $pdo = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', $user, $password);
            $pdo->exec("set names utf8");
            $this->oPDO = $pdo;
        }
        catch (PDOException $e)
        {
            exit($e->getMessage());
        }
    }

}



?>
