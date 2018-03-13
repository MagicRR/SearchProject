<?php
/**
 * Created by PhpStorm.
 * User: aordogh
 * Date: 13/03/2018
 * Time: 11:40
 */

include('../model/dbInfos.php');

$_GET['search'];

if (isset($_GET['search']) && trim($_GET['search'])!="") {

    $req = 'SELECT *
			 	FROM employeelist, message WHERE *=:recherche
				ORDER BY 1 DESC';

    $statement = $this->oPDO->prepare($req);

    $statement->bindValue(':recherche', $_GET['search'], PDO::PARAM_INT);

    $statement->execute();

    $error = $statement->errorInfo();

    if( $error[0] != 00000)
        return $error;
    else
        return $statement->fetchall();


    var_dump($statement);
}