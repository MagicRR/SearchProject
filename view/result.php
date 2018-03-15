<?php include('../model/Model.class.php') ?>

<?php
    ini_set('memory_limit', '-1');

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

        // Concaténation du % pour utiliser le LIKE
        $getSearch = '%'.$_GET['search'].'%';

        // 1ère requête table Employee
        $req = 'SELECT *
    			FROM eurondb.employeelist
                WHERE eid LIKE :recherche
                OR firstName LIKE :recherche
                OR lastName LIKE :recherche
                OR Email_id LIKE :recherche
                OR Email2 LIKE :recherche
                OR Email3 LIKE :recherche
                OR EMail4 LIKE :recherche
                OR status LIKE :recherche
    			ORDER BY 1 DESC';

        $statement = $pdo->prepare($req);

        $statement->bindValue(':recherche', $getSearch);

        $statement->execute();

        $error = $statement->errorInfo();

        if( $error[0] != 00000){
            print_r($error);
        }
        else{
            $searchListEmployee = $statement->fetchall();
        }


        // 2ème requête table Message
        $req2 = 'SELECT *
    			FROM eurondb.message
                WHERE date >= "2002-01-01" AND (
                mid LIKE :recherche
                OR sender LIKE :recherche
                OR date LIKE :recherche
                OR message_id LIKE :recherche
                OR subject LIKE :recherche
                OR body LIKE :recherche)
    			ORDER BY 1 DESC';

        $statement2 = $pdo->prepare($req2);

        $statement2->bindValue(':recherche', $getSearch);

        $statement2->execute();

        $error2 = $statement2->errorInfo();

        if( $error[0] != 00000){
            print_r($error);
        }
        else{
            $searchListMessage = $statement2->fetchall();
        }
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

            <?php

            if (isset($_GET['search']) && trim($_GET['search'])!="")
            {

            ?>

            <br/>
            <h1>Liste des Employés</h1>
            <br/>

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

                    foreach($searchListEmployee as $employees)
                    {
                        echo
                        "
                        <tr>
                            <td>".htmlentities($employees['eid'])."</td>
                            <td>".htmlentities($employees['firstName'])."</td>
                            <td>".htmlentities($employees['lastName'])."</td>
                            <td>".htmlentities($employees['Email_id'])."</td>
                            <td>".htmlentities($employees['status'])."</td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>

            <br/>
            <h1>Liste des Mails</h1>
            <br/>

            <table id="messagesTables" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Expéditeur</th>
                        <th>Sujet</th>
                        <th>Corps du mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach($searchListMessage as $messages)
                    {
                        echo
                        "
                        <tr>
                            <td>".htmlentities($messages['mid'])."</td>
                            <td>".htmlentities($messages['date'])."</td>
                            <td>".htmlentities($messages['sender'])."</td>
                            <td>".htmlentities($messages['subject'])."</td>
                            <td>".htmlentities($messages['body'])."</td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>


            <?php

            }
            else {
                echo "<h1>Il n'y a pas de requête GET</h1>";
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


<script>

$(document).ready(function() {
    $('#employeesTable').DataTable();
} );

$(document).ready(function() {
    $('#messagesTables').DataTable();
} );

</script>
