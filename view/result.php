<?php include('../model/Model.class.php') ?>

<?php
    try
    {
        $pdo = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', $user, $password);
        $pdo->exec("set names utf8");
    }
    catch (PDOException $e)
    {
        exit($e->getMessage());
    }


    if (isset($_GET['search']) && trim($_GET['search'])!="") {

        $req = 'SELECT *
    			FROM eurondb.employeelist WHERE firstName = :recherche
    			ORDER BY 1 DESC';

        $statement = $pdo->prepare($req);

        $statement->bindValue(':recherche', $_GET['search']);

        $statement->execute();

        $error = $statement->errorInfo();

        if( $error[0] != 00000)
            print_r($error);
        else
            $searchList = $statement->fetchall();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recherche</title>
        <meta charset="utf-8">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../style.css">

        <script src="../custom.js"></script>

    </head>

    <body>

        <center>

            <table id="employeesTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Poste</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($searchList as $employees)
                    {
                        echo
                        "
                        <tr>
                            <td>".$employees['eid']."</td>
                            <td>".$employees['firstName']."</td>
                            <td>".$employees['lastName']."</td>
                            <td>".$employees['Email_id']."</td>
                            <td>".$employees['status']."</td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>

        </center>


    </body>

    <footer class="footer">

        <div class="footer-copyright py-3 text-center">
            © 2018 Copyright: Les Guy de l'Insta
        </div>

    </footer>
    <!--/Footer-->

</html>


<script>
$(document).ready(function() {
    $('#employeesTable').DataTable();
} );
</script>
