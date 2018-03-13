<?php

include('dbInfos.php');

class Employee extends Model
{
    public function getListEmployees()
	{
		$req = 'SELECT *
			 	FROM employeelist
				ORDER BY 1 DESC';

		$statement = $this->oPDO->prepare($req);

		$statement->execute();

		$error = $statement->errorInfo();

		if( $error[0] != 00000)
			return $error;
		else
			return $statement->fetchall();
	}
}

?>
