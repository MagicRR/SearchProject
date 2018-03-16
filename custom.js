$(document).ready(function() {

    $('#employeesTable').DataTable();

    $('#messagesTable').DataTable({
        "order": [[ 6, "desc" ]],
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    });
    var motRecherche = "<?php echo $_GET['search']; ?>";

    var regex = new RegExp(motRecherche,"g");

    $('*:contains("' + motRecherche + '")').each(function(){
        if($(this).children().length < 1)
        {
            $(this).html(
                $(this).html().replace(
                    regex,"<span style='color:red'>" + motRecherche + "</span>"
                )
            );
        }

    });

} );