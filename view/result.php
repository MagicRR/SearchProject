<?php include('../model/Employee.class.php') ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recherche</title>
        <meta charset="utf-8">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../style.css">

    </head>

    <body>

        <center>

            <?php

            $employeesInstance = new Employee();
            $employeesList = $employeesInstance->getListEmployees();

            // var_dump($employeesList);

            foreach($employeesList as $employees)
            {
                print_r($employees);
                echo "<br>";
            }

            ?>

        </center>


    </body>

    <footer class="footer">

        <div class="footer-copyright py-3 text-center">
            © 2018 Copyright: Les Guy de l'Insta
        </div>

    </footer>
    <!--/Footer-->

</html>
