<?php

    include('../model/Model.class.php');

    ini_set('memory_limit', '-1');

    try{

        $pdo = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', $user, $password);
        $pdo->exec("set names utf8");
    }
    catch (PDOException $e){
        exit($e->getMessage());
    }

    if ( (isset($_GET['search']) && trim($_GET['search'])!="") && (isset($_GET['choix']) && trim($_GET['choix'])!="")) {

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

        if ($error[0] != 00000) {
            print_r($error);
        } else {
            $searchListEmployee = $statement->fetchall();
        }


        // Recherche sur Message et All
        if( "Employee" != $_GET['choix'] ) {

            $req2 = 'SELECT *
                     FROM eurondb.message AS me
                     LEFT JOIN eurondb.employeelist ON me.sender = eurondb.employeelist.Email_id
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

            if ($error2[0] != 00000) {
                print_r($error);
            } else {
                $searchListMessage = $statement2->fetchall();
            }
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

    </head>

    <body>
        <main>

            <center>

                <?php

                if ( (isset($_GET['search']) && trim($_GET['search'])!="") && (isset($_GET['choix']) && trim($_GET['choix'])!="")) {
                    if( "Message" != $_GET['choix'] ) {

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

                            foreach ($searchListEmployee as $employees) {
                                echo
                                    "
                            <tr>
                                <td>" . htmlentities($employees['eid']) . "</td>
                                <td>" . htmlentities($employees['firstName']) . "</td>
                                <td>" . htmlentities($employees['lastName']) . "</td>
                                <td>" . htmlentities($employees['Email_id']) . "</td>
                                <td>" . htmlentities($employees['status']) . "</td>
                            </tr>
                            ";
                            }
                            ?>
                            </tbody>
                        </table>

                        <?php

                    }
                    if( "Employee" != $_GET['choix'] ) {

                        ?>
                        <br/>
                        <h1>Liste des Mails</h1>
                        <br/>

                        <table id="messagesTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Expéditeur</th>
                                <th>Sujet</th>
                                <th>Corps du mail</th>
                                <th>Occurences du mot</th>
                                <th>Poids de la recherche</th>
                                <th>Multiplicateur</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            // Attention, c'est parti pour l'algorithme
                            foreach ($searchListMessage as $messages) {

                                // Initialisation de l'algorithme
                                $messages['pertinence'] = 0;

                                // Occurences dans le sender, poids * 10
                                $occurencesInSender = substr_count($messages['sender'], $_GET['search']);
                                // Uppercase
                                $occurencesInSender += substr_count($messages['sender'], strtoupper($_GET['search']));
                                // Lowercase
                                $occurencesInSender += substr_count($messages['sender'], strtolower($_GET['search']));
                                // Total sender
                                $messages['pertinence'] += $occurencesInSender * 10;


                                // Occurences dans la date, poids * 100
                                $occurencesInDate = substr_count($messages['date'], $_GET['search']);
                                // Uppercase
                                $occurencesInDate += substr_count($messages['date'], strtoupper($_GET['search']));
                                // Lowercase
                                $occurencesInDate += substr_count($messages['date'], strtolower($_GET['search']));
                                // Total sender
                                $messages['pertinence'] += $occurencesInDate * 100;


                                // Occurences dans le subject, poids * 5
                                $occurencesInSubject = substr_count($messages['subject'], $_GET['search']);
                                // Uppercase
                                $occurencesInSubject += substr_count($messages['subject'], strtolower($_GET['search']));
                                // Lowercase
                                $occurencesInSubject += substr_count($messages['subject'], strtolower($_GET['search']));
                                // Total subject
                                $messages['pertinence'] += $occurencesInSubject * 5;


                                // Occurences dans le body, poids * 1
                                $occurencesInBody = substr_count($messages['body'], $_GET['search']);
                                // Uppercase
                                $occurencesInBody += substr_count($messages['body'], strtoupper($_GET['search']));
                                // Lowercase
                                $occurencesInBody += substr_count($messages['body'], strtolower($_GET['search']));
                                // Total body
                                $messages['pertinence'] += $occurencesInBody;


                                $totalOccurences = $occurencesInSender + $occurencesInSubject + $occurencesInBody + $occurencesInDate;


                                if($messages['status'] == 'CEO'){
                                    $messages['multiplicateur'] = 10;
                                }
                                elseif($messages['status'] == 'President') {
                                    $messages['multiplicateur'] = 5;
                                }
                                elseif($messages['status'] == 'Vice President') {
                                    $messages['multiplicateur'] = 5;
                                }
                                elseif($messages['status'] == 'Director') {
                                    $messages['multiplicateur'] = 3;
                                }
                                elseif($messages['status'] == 'In House Lawyer') {
                                    $messages['multiplicateur'] = 3;
                                }
                                elseif($messages['status'] == 'Managing Director') {
                                    $messages['multiplicateur'] = 2.5;
                                }
                                elseif($messages['status'] == 'Manager') {
                                    $messages['multiplicateur'] = 2;
                                }
                                elseif($messages['status'] == 'Trader') {
                                    $messages['multiplicateur'] = 1.25;
                                }
                                elseif($messages['status'] == 'Employee') {
                                    $messages['multiplicateur'] = 1;
                                }
                                else{
                                    $messages['multiplicateur'] = 0.75;
                                }

                                $messages['pertinence'] = $messages['pertinence'] * $messages['multiplicateur'];

                                echo
                                    "
                            <tr>
                                <td>" . htmlentities($messages['mid']) . "</td>
                                <td>" . htmlentities($messages['date']) . "</td>
                                <td>" . htmlentities($messages['sender']) . "</td>
                                <td>" . htmlentities($messages['subject']) . "</td>
                                <td><div id=".$messages['mid']." class='cut-text everyText'>" . htmlentities($messages['body']) . "</div></td>
                                <td>" . $totalOccurences . "</td>
                                <td>" . $messages['pertinence'] . "</td>
                                <td>" . $messages['multiplicateur'] . "</td>
                            </tr>
                            ";
                            }
                            ?>
                            </tbody>
                        </table>


                        <?php
                    }
                }
                else {
                    echo "<h1>Il n'y a pas de requête GET</h1>";
                }

                ?>

            </center>
        </main>

    </body>

    <footer class="footer">

        <div class="footer-copyright py-3 text-center">
            © 2018 Copyright: Les Guy de l'Insta
        </div>

    </footer>

</html>

<script>

    $(document).ready(function() {

        $('#employeesTable').DataTable();

        $('#messagesTable').DataTable({
            "order": [[ 6, "desc" ]],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
        });

        // Mot recherche
        var motRecherche = "<?php echo $_GET['search']; ?>";
        var regex = new RegExp(motRecherche,"g");

        $('*:contains("' + motRecherche + '")').each(function(){

            if($(this).children().length < 1){
                $(this).html(
                    $(this).html().replace(
                        regex,"<span class='motRechercheColor'>" + motRecherche + "</span>"
                    )
                );
            }

        });

        // Mot recherche uppercase first letter
        var motRechercheUpperFirstLetter = motRecherche.charAt(0).toUpperCase()+motRecherche.slice(1);
        var regexUpperFirstLetter = new RegExp(motRechercheUpperFirstLetter,"g");

        $('*:contains("' + motRechercheUpperFirstLetter + '")').each(function(){

            if($(this).children().length < 1){
                $(this).html(
                    $(this).html().replace(
                        regexUpperFirstLetter,"<span class='motRechercheColor'>" + motRechercheUpperFirstLetter + "</span>"
                    )
                );
            }

        });

        // Mot recherche lowercase first letter
        var motRechercheLowerFirstLetter = motRecherche.charAt(0).toLowerCase()+motRecherche.slice(1);
        var regexLowerFirstLetter = new RegExp(motRechercheLowerFirstLetter,"g");

        $('*:contains("' + motRechercheLowerFirstLetter + '")').each(function(){

            if($(this).children().length < 1){
                $(this).html(
                    $(this).html().replace(
                        regexLowerFirstLetter,"<span class='motRechercheColor'>" + motRechercheLowerFirstLetter + "</span>"
                    )
                );
            }

        });

        // Mot recherche uppercase
        var motRechercheUpper = motRecherche.charAt(0).toUpperCase()+motRecherche.slice(1);
        var regexUpper = new RegExp(motRechercheUpper,"g");

        $('*:contains("' + motRechercheUpper + '")').each(function(){

            if($(this).children().length < 1){
                $(this).html(
                    $(this).html().replace(
                        regexUpper,"<span class='motRechercheColor'>" + motRechercheUpper + "</span>"
                    )
                );
            }

        });

        // Mot recherche lowercase
        var motRechercheLower = motRecherche.charAt(0).toUpperCase()+motRecherche.slice(1);
        var regexLower = new RegExp(motRechercheLower,"g");

        $('*:contains("' + motRechercheLower + '")').each(function(){

            if($(this).children().length < 1){
                $(this).html(
                    $(this).html().replace(
                        regexLower,"<span class='motRechercheColor'>" + motRechercheLower + "</span>"
                    )
                );
            }

        });

        $(".cut-text").click(function( event )
        {
            $("#"+event.target.id).toggleClass("cut-text");
        });

    } );

</script>
