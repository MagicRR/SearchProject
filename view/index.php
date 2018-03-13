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

            <img src="../img/enron-logo" id="logo"/>

            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                    <form action="result.php" method="GET">
                        <input type="text" class="form-control" name="search" placeholder="Search..." id="searchInput">
                        <button type="submit" class="btn btn-primary" id="buttonSubmit"><i class="fa fa-search"></i></button>
                    </form>



                </div>
            </div>

        </center>


    </body>

    <footer class="footer">

        <div class="footer-copyright py-3 text-center">
            © 2018 Copyright: Les Guy de l'Insta
        </div>

    </footer>
    <!--/Footer-->

</html>
